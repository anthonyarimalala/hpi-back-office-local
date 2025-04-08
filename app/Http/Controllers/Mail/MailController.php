<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Models\devis\DevisAppelsEtMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function modifyMail(Request $request){
        $mail_name = $request->input('mail_name');
        $mail = $request->input('mail');
        $mail_password = $request->input('mail_password');

        $user = User::where('code_u', Auth::user()->code_u)->first();
        $user->mail_sender = $mail;
        $user->mail_password = Crypt::encrypt($mail_password);
        $user->mail_name = $mail_name;
        $user->save();

        /*
        Config::set('mail.username', $mail);
        Config::set('mail.password', $mail_password);
        Config::set('mail.from.address', $mail);
        Config::set('mail.from.name', $mail_name);
        */

        return back();
    }
    public function showModidyMail(Request $request){
        return view('mail/modifyMail');
    }
    public function envoiMail(Request $request){
        $email = $request->input('email');
        $objet = $request->input('objet');
        $message = $request->input('message');
        $id_devis = $request->input('id_devis');
        $devis_appels_mails = DevisAppelsEtMail::where('id_devis', $id_devis)->first();
        $devis_appels_mails->email_sent = 1;
        $devis_appels_mails->save();

        //echo $email;
        $user = Auth::user();
        $mail_sender = $user->mail_sender;
        $mail_name = $user->mail_name;

        if (!$mail_sender || $mail_sender == '') {
            return back()->withErrors([
                'mail_sender' => "L'email n'a pas été envoyé.<br>Le champ expéditeur est requis. Veuillez aller dans « Modifier l'adresse mail »."
            ]);

        }



        /*
        Config::set('mail.username', 'anthonyarimalal@gmail.com');
        Config::set('mail.password', $mail_password);
        Config::set('mail.from.address', $mail_sender);
        Config::set('mail.from.name', $mail_name);
        */

        try {
            $mail_password = Crypt::decrypt($user->mail_password);
            config([
                'mail.mailers.smtp.username' => $mail_sender,
                'mail.mailers.smtp.password' => $mail_password,
                'mail.from.name' => $mail_name,
                'mail.from.address' => $mail_sender,
            ]);

            \Illuminate\Support\Facades\Mail::to($email)
                ->send(new \App\Mail\HelloMail($objet, $message));
        }
        catch (\Exception $exception){
            return back()->withErrors([
                'mail_sender' => "L'email n'a pas été envoyé.<br>Une erreur est survenue. Vérifiez votre email ou retapez votre mot de passe.<br>Veuillez aller dans « Modifier l'adresse mail » et vérifier votre email ou retaper votre mot de passe."
            ]);
        }


        return back()->with('success', 'L\'email a bien été envoyé');

    }
}
