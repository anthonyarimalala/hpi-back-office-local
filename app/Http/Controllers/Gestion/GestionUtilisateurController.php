<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserToConfirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GestionUtilisateurController extends Controller
{
    //
    public function confirmUserToConfirm($id_user_to_confirm){
        $userToConfirm = UserToConfirm::find($id_user_to_confirm);
        if(!$userToConfirm){
            return back()->withErrors(['alert', 'Cette personne n\'existe plus dans la base de données. Il sera nécessaire qu\'elle s\'enregistre de nouveau.']);
        }
        $max_id = DB::select("SELECT COALESCE(MAX(SUBSTRING(code_u FROM '[0-9]+')::INTEGER), 0) AS max_code FROM users WHERE code_u LIKE 'U%'")[0]->max_code;
        $newCodeU = User::generateCodeNonSeq('U', 4, $max_id+1);
        $user = new User();
        $user->code_u = $newCodeU;
        $user->nom = $userToConfirm->nom;
        $user->prenom = $userToConfirm->prenom;
        $user->password = $userToConfirm->password;
        $user->email = $newCodeU.'@gmail.com';
        $user->role = 'user';
        $user->is_deleted = 0;
        $user->save();
        DB::delete('DELETE FROM users_to_confirms WHERE id=?', [$id_user_to_confirm]);
        return back()->with('success', 'Opération effectuée avec succès.');;

    }
    public function deleteUserToConfirm($id_user_to_confirm){
        DB::delete('DELETE FROM users_to_confirms WHERE id=?', [$id_user_to_confirm]);
        return back();
    }

    public function modifierMdp(Request $request){
        // Validation des données
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Vérifier si l'ancien mot de passe est correct
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->withErrors(['old_password' => 'Ancien mot de passe invalide']);
        }
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->is_deleted = 0;
        $user->save();
        return back()->with('success', 'Mot de passe modifié avec succès.');
    }
    public function showModifierMdp(){
        // Vérifier le mot de passe de l'utilisateur connecté
        $user = Auth::user();
        $data['m_user'] = User::where('code_u', $user->code_u)->first();
        return view('gestion/modifier-mdp')->with($data);
    }
    public function updateUtilisateur(Request $request, $code_u){
        // Vérifier le mot de passe de l'utilisateur connecté
        if (!Hash::check($request->password_confirmation, Auth::user()->password)) {
            return back()->withErrors(['password_confirmation' => 'Mot de passe incorrect.']);
        }

        $m_user = User::where('code_u', $code_u)->first();
        $role = $request->get("role");
        $m_user->role = $role;
        echo 'role: '.$role;
        $m_user->save();
        return back();
    }
    public function effacerUtilisateur(Request $request, $code_u){
        if (!Hash::check($request->password_confirmation, Auth::user()->password)) {
            return back()->withErrors(['password_confirmation' => 'Mot de passe incorrect.']);
        }
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
            'is_deleted' => -1,
        ]);
        return back();
    }
    public function showListeUtilisateurs(){
        $data['utilisateurs'] = User::where('is_deleted', '!=', 1)
            ->get();
        $data['utilisateurs_to_confirm'] = UserToConfirm::orderBy('id', 'desc')->get();
        return view('gestion/utilisateur/liste-user')->with($data);
    }
}
