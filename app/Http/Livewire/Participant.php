<?php

namespace App\Http\Livewire;

use App\Models\participan;
use App\Models\reunion;
use App\Models\reunionParticipan;
use App\Models\User;
use Livewire\Component;

class Participant extends Component
{
    public $existe = true;
    public $modif = true;
    public $client = "";
    public $user;
    public $tab;
    public $nom = "";
    public $postnom = "";
    public $prenom = "";
    public $phone = "";
    public $email = "";
    public $ids = "";
    public $reunion = "";
    public $sexe = "";
    public $description = "";
    public $libelles = [];
    public $statuts = null;
    public $selectstatut = null;
    protected $queryString = [
        'client' => ['except' => ''],
    ];

    private function s($val)
    {
        return $val > 2 ? "s" : "";
    }
    public function amount()
    {
        $this->libelles = collect();
    }
    public function updatedClient()
    {
        $cl = trim($this->client);
        $this->tab = participan::where("phone", "LIKE", "{$cl}")
            ->orWhere("email", "LIKE", "{$this->client}")
            ->first();

        // dd($this->tab);
        if ($this->tab) {
            $this->existe = false;
            $this->ids = $this->tab->id;
            session()->flash('message', ' Client ' . $this->s($this->tab->count()) . ' trouvé' . $this->s($this->tab->count()));
            session()->flash('type', 'success');
        } else {
            $this->existe = true;
            session()->flash('message', 'Aucun client trouvé');
            session()->flash('type', 'danger');
        }

        return $this->tab;
    }
    public function store($id)
    {
        if ($this->reunion != "") {
            //dd($this->reunion);
            $retour = reunionParticipan::where([["participan_id", $id], ["reunion_id", $this->reunion]])->first();
            $nbreunion = reunionParticipan::where([["reunion_id", $this->reunion]])->get();
            $reun=reunion::find($this->reunion);
            if($nbreunion->count()==$reun->quota){
                session()->flash('message', "Impossible d'enregistrer ce participant dans cette réunion car son quota est atteind!");
                session()->flash('type', 'danger');
            }else{
                if ($retour) {
                    session()->flash('message', 'Ce client est déjà enregistrer pour cet evenement');
                    session()->flash('type', 'warning');
                } else {
                    $qrinfo = reunionParticipan::create([
                        'participan_id' => $id,
                        'reunion_id' => $this->reunion,
                    ]);
                    session()->flash('message', 'Enregistrement réussit');
                    session()->flash('type', 'success');
                    session()->flash('qrcode', $qrinfo->id);
                    $this->vider();
                }
            }
        } else {
            session()->flash('message', 'Aucune réunion selectionée');
            session()->flash('type', 'danger');
        }
    }
    protected $rules = [
        'nom' => 'required',
        'phone' => 'unique:' . participan::class,
        'email' => 'unique:' . participan::class,
    ];
    public function saveClient()
    {
        if ($this->ids == "") {
            $this->validate();


            $client = participan::create([
                'nom' => $this->nom,
                'postnom' => $this->postnom,
                'prenom' => $this->prenom,
                'sexe' => $this->sexe,
                'phone' => $this->phone,
                'email' => $this->email,
            ]);
            if ($client) {
                session()->flash('message', 'Enregistrement réussit');
                session()->flash('type', 'success');
                $this->vider();

            } else {
                session()->flash('message', 'Erreur d\'enregistrement');
                session()->flash('type', 'danger');
            }
        } else {
            $cl = participan::find($this->ids);
            // dd($this->nom);
            if ($cl) {
                $cl->nom = $this->nom;
                $cl->postnom = $this->postnom;
                $cl->prenom = $this->prenom;
                $cl->sexe = $this->sexe;
                $cl->phone = $this->phone;
                $cl->email = $this->email;
                $cl->save();
                if ($cl) {
                    session()->flash('message', 'Enregistrement réussit');
                    session()->flash('type', 'success');
                    $this->vider();

                }
            }
        }
    }
    public function modifClient()
    {
        // dd('ok');
        if ($this->ids == "") {
            $this->vider();
            $this->notify("danger", "Echec de modification", "Merci");
        } else {
            $cl = participan::find($this->ids);
            if ($cl) {
                $cl->nom = $this->nom == "" ? $cl->nom : $this->nom;
                $cl->postnom = $this->postnom == "" ? $cl->postnom : $this->postnom;
                $cl->prenom = $this->prenom == "" ? $cl->prenom : $this->prenom;
                $cl->sexe = $this->sexe == "" ? $cl->sexe : $this->sexe;
                $cl->phone = $this->phone == "" ? $cl->phone : $this->phone;
                $cl->email = $this->email == "" ? $cl->email : $this->email;
                $cl->save();
                $this->vider();
                $this->notify("success", "Modification réussit", "Merci");
            }
        }
    }
    private function notify($type, $msg, $titre)
    {
        session()->flash('message', $msg);
        session()->flash('type', $type);
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => $type,
            'titre' => $titre,
            'text' => $msg,
            'from' => "client",
        ]);
    }
    public function opneFolder($id)
    {
        $this->user = participan::where("id", $id)
            ->first();
        $this->nom = $this->user->nom;
        $this->postnom = $this->user->postnom;
        $this->prenom = $this->user->prenom;
        $this->phone = $this->user->phone;
        $this->sexe = $this->user->sexe;
        $this->ids = $this->user->id;
        $this->modif = false;
    }

    private function vider()
    {
        $this->nom = "";
        $this->postnom = "";
        $this->prenom = "";
        $this->phone = "";
        $this->email = "";
        $this->sexe = "";
        $this->ids = "";
        $this->client = "";

        $this->libelles = [];
        $this->statuts = null;
        $this->selectstatut = null;
        $this->existe = true;
        $this->modif = true;
    }

    public function render()
    {
        //dd(today());
        $reunions = reunion::where([["status","!=", "fermee"], ["date_fin", ">", now()]])
            ->get();
        //dd($reunions);
        return view('livewire.participant', compact('reunions'));
    }
}
