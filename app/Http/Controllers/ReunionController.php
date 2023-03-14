<?php

namespace App\Http\Controllers;

use App\Models\reunion;
use Illuminate\Http\Request;
use App\Http\Requests\StorereunionRequest;
use App\Http\Requests\UpdatereunionRequest;
use App\Models\participan;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $liste=reunion::with("participan")->where('id',$id)->first();
        //  dd($liste->participan);
        return view("pages/liste",compact("liste"));
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
        $resultat= reunion::create([
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

    public function scanne(){
        return view("pages/scanne");
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        // $image=QrCode::size(300)
        // ->format("png")
        // ->merge('img/t.jpg', 0.1, true)
        // ->errorCorrection('H')
        // ->generate("https://beraca.hardymuanda.com/qreunion.php?reunion=");

        return view('pages/scanne');

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
