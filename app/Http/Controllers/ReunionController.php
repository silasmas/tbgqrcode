<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatereunionRequest;
use App\Models\participan;
use App\Models\presence;
use App\Models\reunion;
use App\Models\reunionParticipan;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReunionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $freunions = reunion::where([["status", "Ouvert"], ["date_fin", ">", now()]])->with("participan")->get();
        $reunions = reunion::with("participan")->get();
        $participan = participan::with("reunion")->get();

        return view("pages/reunion", compact("reunions", "freunions", "participan"));
    }
    public function viewListe($id)
    {
        $liste = reunion::with("participan")->where('id', $id)->first();

        return view("pages/liste", compact("liste"));
    }
    public function viewListeReunion($id)
    {
        $liste = participan::with("reunion")->where('id', $id)->first();
        $listePart = true;
// dd($liste->reunion);
        return view("pages/liste", compact("liste", "listePart"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file('image');

        $file == '' ? '' : ($filenameImg = 'reunion/' . time() . '.' . $file->getClientOriginalName());
        $file == '' ? '' : $file->move('storage/reunion', $filenameImg);
        // dd($filenameImg);
        $resultat = reunion::create([
            'titre' => $request->titre,
            'subtitre' => $request->subtitre,
            'type' => $request->type,
            'context' => $request->contexte,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'quota' => $request->quota,
            'status' => $request->status,
            'image' => $filenameImg,
        ]);
        if ($resultat) {
            return back()->with(['message' => 'Enregistrement réussi', "type" => "success"]);
        } else {
            return back()->with(['message' => 'Merci de vérifier le formulaire!', "type" => "danger"]);
        }
    }

    public function scanne()
    {

        return view("pages/scanne");
    }
    public function verify($id)
    {
        $id = explode('.', $id);
        $retour = reunionParticipan::where([["participan_id", $id[0]], ["reunion_id", $id[1]], ["status", "Valide"]])->first();
        // dd($retour);
        if ($retour) {
            $p = presence::where([["participan_id", $id[0]], ["reunion_id", $id[1]], ["etat", "present"]])->first();
            if ($p) {

                $participant = participan::find($id[0]);
                $reunion = reunion::find($id[1]);
                $msg = "A déjà eu accès la conférence $reunion->titre";
                return view("pages/scanne", compact("participant", "reunion", "msg"));
            } else {
                presence::create([
                    'jour' => NOW(),
                    'participan_id' => $id[0],
                    'reunion_id' => $id[1],
                ]);
                $participant = participan::find($id[0]);
                $reunion = reunion::find($id[1]);
                $msg = "Accès accordé à la réunion $reunion->titre";
                return view("pages/scanne", compact("participant", "reunion", "msg"));
            }
        } else {
            dd($retour);
        }

    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $data = "https://tbg.silasmas.com/verify/" . $id;
        $image = QrCode::size(200)->format("png")
            ->merge('https://tbg.silasmas.com/public/assets/img/logo.jpg', 0.2, true)
            ->generate("$data");
        echo '<img src="data:image/png;base64,' . base64_encode($image) . '" alt="QR Code" />';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(reunion $reunion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatereunionRequest $request, reunion $reunion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $present = reunionParticipan::where("reunion_id", $id)->get();
        // $i = explode('.', $id);
        // $retour = reunionParticipan::where([["participan_id", $i[0]], ["reunion_id", $i[1]], ["status", "Valide"]])->first();
        
        if ($present->count() > 0) {
            return response()->json([
                'reponse' => false,
                'msg' => 'Impossible de supprimer cette réunion car elle contient au-moins un participant',
            ]);
        } else {
            $reunion = reunion::find($id);
            if ($reunion) {
                $reunion->delete();
                if ($reunion) {
                    return response()->json([
                        'reponse' => true,
                        'msg' => 'Suppression Réussie.',
                    ]);
                }
            } else {
                return response()->json([
                    'reponse' => false,
                    'msg' => 'Erreur de suppression',
                ]);
            }
        }
    }

    public function delPartReunion($id)
    {
        $i = explode('.', $id);
        $retour = reunionParticipan::where([["participan_id", $i[0]], ["reunion_id", $i[1]], ["status", "Valide"]])->first();

        if ($retour) {
            $retour->delete();
            if ($retour) {
                return response()->json([
                    'reponse' => true,
                    'msg' => 'Suppression Réussie.',
                ]);
            }

        } else {
            return response()->json([
                'reponse' => false,
                'msg' => 'Erreur de suppression!!',
            ]);

        }

    }
}
