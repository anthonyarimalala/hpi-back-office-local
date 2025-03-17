<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Models\devis\DevisAppelsEtMail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    //
    public function envoiMail(Request $request){
        $email = $request->input('email');
        $objet = $request->input('objet');
        $message = $request->input('message');
        $id_devis = $request->input('id_devis');
        $devis_appels_mails = DevisAppelsEtMail::where('id_devis', $id_devis)->first();
        $devis_appels_mails->email_sent = 1;
        $devis_appels_mails->save();

        //echo $email;

        \Illuminate\Support\Facades\Mail::to($email)
            ->send(new \App\Mail\HelloMail($objet, $message));
        return back()->with('success', 'L\'email a bien été envoyé');

    }
}
