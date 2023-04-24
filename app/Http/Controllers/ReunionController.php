<?php

namespace App\Http\Controllers;

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
        // $image = Builder::create()
        //     ->writer(new PngWriter())
        //     ->writerOptions([])
        //     ->data($data)
        //     ->encoding(new Encoding('UTF-8'))
        //     ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        //     ->size(300)
        //     ->margin(10)
        //     ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
        // // ->logoPath("https://tbg.silasmas.com/public/assets/img/logo.jpg")
        //     ->logoPath(public_path() . '/assets/img/logo.png')
        //     ->labelText('This is the label')
        //     ->labelFont(new NotoSans(20))
        //     ->labelAlignment(new LabelAlignmentCenter())
        //     ->validateResult(false)
        //     ->build();

        // $writer = new PngWriter();

        // // Create QR code
        // $qrCode = QrCode::create('Life is too short to be generating QR codes')
        //     ->setEncoding(new Encoding('UTF-8'))
        //     ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
        //     ->setSize(300)
        //     ->setMargin(10)
        //     ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
        //     ->setForegroundColor(new Color(0, 0, 0))
        //     ->setBackgroundColor(new Color(255, 255, 255));

        // // Create generic logo
        // $logo = Logo::create(__DIR__.'/assets/symfony.png')
        //     ->setResizeToWidth(50);

        // // Create generic label
        // $label = Label::create('Label')
        //     ->setTextColor(new Color(255, 0, 0));

        // $result = $writer->write($qrCode, $logo, $label);

        // // Validate the result
        // $writer->validateResult($result, 'Life is too short to be generating QR codes');

        $image = QrCode::size(150)->format("png")
            ->merge('https://tbg.silasmas.com/public/assets/img/logo.jpg', 0.2, true)
            ->padd(255, 255, 255)
            ->backgroundColor(255, 255, 255)
            ->generate("$data");

        //echo '<img src="data:image/png;base64,' . base64_encode($image) . '" alt="QR Code" />';
        // dd($image);
        return view("qrcode", compact("image"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categorie = reunion::find($id);
        $freunions = reunion::where([["status", "Ouvert"], ["date_fin", ">", now()]])->with("participan")->get();
        $reunions = reunion::with("participan")->get();
        $participan = participan::with("reunion")->get();

        return view("pages/reunion", compact("categorie", "reunions", "freunions", "participan"));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $reunion = reunion::find($request->id);
        if ($reunion) {
            $file = $request->file('image');
            if ($file != "") {
                $photo = public_path() . '/storage/' . $reunion->image;
                file_exists($photo) ? unlink($photo) : '';
            }
            $file == '' ? "" : ($filenameImg = 'reunion/' . time() . '.' . $file->getClientOriginalName());
            $file == '' ? "" : $file->move('storage/reunion', $filenameImg);
            $reunion->update([
                'titre' => $request->titre,
                'subtitre' => $request->subtitre,
                'titre' => $request->titre,
                'type' => $request->type,
                'context' => $request->contexte,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'quota' => $request->quota,
                'status' => $request->status,
                'image' => isset($filenameImg) ? $filenameImg : $reunion->image,
            ]);
            $freunions = reunion::where([["status", "Ouvert"], ["date_fin", ">", now()]])->with("participan")->get();
            $reunions = reunion::with("participan")->get();
            $participan = participan::with("reunion")->get();

            return redirect("reunion")
                ->with(['message' => 'La modification est faite avec succès', "type" => "success"]);

        } else {
            return back()->with(['message' => 'Erreur de modification', "type" => "danger"]);
        }
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
        // dd($id);
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
