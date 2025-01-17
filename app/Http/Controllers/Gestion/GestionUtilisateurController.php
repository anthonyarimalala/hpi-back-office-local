<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GestionUtilisateurController extends Controller
{
    //
    public function effacerUtilisateur($code_u){
        $user = User::where('code_u', $code_u)->first();
        $user->is_deleted = 1;
        $user->save();
        return back();
    }
    public function creerUtilisateur(Request $request){
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $max_id = DB::select("SELECT COALESCE(MAX(SUBSTRING(code_u FROM '[0-9]+')::INTEGER), 0) AS max_code FROM users WHERE code_u LIKE 'U%'")[0]->max_code;
        $newCodeU = User::generateCodeNonSeq('U', 4, $max_id+1);
        // Créer un nouvel utilisateur
        $user = User::create([
            'code_u' => $newCodeU,
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'role' => 'user',
            'email' => $newCodeU.'@gmail.com',
            'password' => Hash::make($validatedData['password']),
        ]);
        return back();
    }
    public function showListeUtilisateurs(){
        $data['utilisateurs'] = User::where('is_deleted', 0)
            ->get();
        return view('gestion/utilisateur/liste-user')->with($data);
    }
}
