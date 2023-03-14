<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatereunionRequest;
use App\Models\participan;
use App\Models\reunion;
use App\Models\reunionParticipan;
use chillerlan\QRCode\QRCode;
use Illuminate\Http\Request;

class ReunionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view("pages/reunion");
    }
    public function viewListe($id)
    {
        $liste = reunion::with("participan")->where('id', $id)->first();
        //   dd($liste);
        return view("pages/liste", compact("liste"));
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
        $retour = reunionParticipan::where([["participan_id", $id[0]], ["reunion_id", $id[0]], ["status", "valide"]])->first();
        if ($retour) {
            $participant=participan::find($id[0]);
            $reunion=reunion::find($id[1]);
            return view("pages/scanne");
        } else {

        }
        
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $data = "https://tbg.silasmas.com/verify/" . $id;
        // $file->move('storage/qrcode', $filenameImg);
        //  return (new QRCode)->render($data);
        echo '<img src="' . (new QRCode)->render($data) . '" alt="QR Code" />';
        //$image= (new QRCode)->render($data);
        // $image=QrCode::size(300)
        // ->format("png")
        // // ->merge('img/t.jpg', 0.1, true)
        // // ->errorCorrection('H')
        // ->generate("https://beraca.hardymuanda.com/qreunion.php?reunion=");

        // return $image;

        // $output_file = '/img/qr-code/img-' . time() . '.png';
        // Storage::disk('local')->put($output_file, $image);
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
    public function destroy(reunion $reunion)
    {
        //
    }
}
