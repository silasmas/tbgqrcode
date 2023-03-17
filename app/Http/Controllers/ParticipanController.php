<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreparticipanRequest;
use App\Http\Requests\UpdateparticipanRequest;
use App\Models\participan;
use App\Models\presence;
use App\Models\reunion;
use App\Models\reunionParticipan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParticipanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function login(Request $request)
    {
        $user = $request->validate([
            "email" => ['required', 'email'],
            "password" => ['required', 'string'],
        ]);
        // dd($user['email']);
        $resultat = User::where("email", $user['email'])->first();
        if (!$resultat) {
            return response(['reponse' => false, 'message' => 'Aucun utilisateur trouvé avec cette email!'], 401);
        }
        if (!Hash::check($user['password'], $resultat->password)) {
            return response(['reponse' => false, 'message' => 'Aucun utilisateur trouvé avec ce mot de passe!'], 401);
        }
        $token = $resultat->createToken("CLE_SECRET")->plainTextToken;
        return response([
            "user" => $resultat,
            "token" => $token,
        ], 200);
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
    public function store(StoreparticipanRequest $request)
    {
        $resultat = User::where("email", $request->email)->first();
        if (!$resultat) {
            return response(['reponse' => false, 'message' => 'Aucun utilisateur trouvé avec cette email!'], 401);
        }
        if (!Hash::check($request->password, $resultat->password)) {
            return response(['reponse' => false, 'message' => 'Aucun utilisateur trouvé avec ce mot de passe!'], 401);
        }
        $token = $resultat->createToken("CLE_SECRET")->plainTextToken;
        return response([
            "success" => true,
            "user" => $resultat,
            "token" => $token,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function verify($id)
    {
        $id = explode('.', $id);
        $reu = reunion::where([['id', $id[1]], ['status', 'Ouvert'], ['date_fin', ">", NOW()]])->first();
        // dd($reu);
        if (!$reu) {
            return response([
                "success" => false,
                "message" => "Cette réunion n'est plus actuelle, ce QRCODE n'est plus valide",
            ], 401);
        } else {

            $retour = reunionParticipan::where([["participan_id", $id[0]], ["reunion_id", $id[1]], ["status", "Valide"]])->first();
            // dd($retour);
            if ($retour) {
                $p = presence::where([["participan_id", $id[0]], ["reunion_id", $id[1]], ["etat", "present"]])->first();
                if ($p) {
                    $participant = participan::find($id[0]);
                    $reunion = reunion::find($id[1]);

                    $msg = $participant->prenom . "-" . $participant->nom . " a déjà eu accès la conférence $reunion->titre";
                    return response([
                        "success" => true,
                        "message" => $msg,
                        "participant" => $participant,
                        "reunion" => $reunion,
                    ], 200);
                } else {
                    presence::create([
                        'jour' => NOW(),
                        'participan_id' => $id[0],
                        'reunion_id' => $id[1],
                    ]);
                    $participant = participan::find($id[0]);
                    $reunion = reunion::find($id[1]);
                    $msg = $participant->prenom . "-" . $participant->nom . " Accès accordé à la réunion $reunion->titre";
                    return response([
                        "success" => true,
                        "message" => $msg,
                        "participant" => $participant,
                        "reunion" => $reunion,
                    ], 200);
                }
            } else {
                return response([
                    "success" => false,
                    "message" => "Cette personne n'est pas trouvée dans la liste des participant de cette réunion",
                ], 401);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(participan $participan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateparticipanRequest $request, participan $participan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(participan $participan)
    {
        //
    }
}
