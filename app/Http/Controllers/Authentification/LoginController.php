<?php

namespace App\Http\Controllers\Authentification;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserToConfirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function registerToConfirm(Request $request){
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user_to_confirm = new UserToConfirm();
        $user_to_confirm->nom = $validatedData['nom'];
        $user_to_confirm->prenom = $validatedData['prenom'];
        $user_to_confirm->password = Hash::make($validatedData['password']);
        $user_to_confirm->save();
        return redirect('/login')->with('warning', 'Votre inscription a été prise en compte. Veuillez attendre la confirmation de l\'administrateur pour recevoir votre code utilisateur.');

    }

    public function register(Request $request)
    {
        // Valider les données
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

        auth()->login($user);
        return redirect('/')->with('warning', 'Votre inscription a été prise en compte. Veuillez attendre la confirmation de l\'administrateur pour recevoir votre code utilisateur.');
    }

    public function login(Request $request){

        $credentials = $request->validate([
            'code_u' => 'required|string',
            'password' => 'required',
        ]);

        $user = User::where('code_u', $request->code_u)
            ->where('is_deleted', '!=', 1);
        if($user == null){
            return back()->withErrors([
                'code_u' => 'Code Utilisateur non reconu.',
            ]);
        }else if(Auth::attempt(['code_u' => $credentials['code_u'], 'password'=>$credentials['password']])){
            $request->session()->regenerate();
            return redirect('/');
        }
        return back()->withErrors([
            'password' => 'Mot de passe incorrect.',
        ]);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirectionRoute(){
        if (Auth::user() == null){
            redirect('/login');
        }
        else if (Auth::user()->role == 'admin'){
            redirect('/dashboard');
        }

    }
}
