<?php

namespace App\Http\Controllers\Dossier\Cheque;

use App\Http\Controllers\Controller;
use App\Models\devis\cheque\InfoCheque;
use App\Models\devis\cheque\InfoChequeNatureCheque;
use App\Models\devis\cheque\InfoChequeSituationCheque;
use App\Models\devis\cheque\InfoChequeTravauxDevis;
use App\Models\hist\H_Cheque;
use App\Models\views\V_Cheque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChequeController extends Controller
{
    //
    public function modifierCheque(Request $request, $id_acte)
    {

        // Récupérer les valeurs du formulaire
        $id_devis = $request->input('id_devis');
        $dossier = $request->input('dossier');
        $numero_cheque = $request->input('numero_cheque');
        $montant_cheque = $request->input('montant_cheque');
        $nom_document = $request->input('nom_document');
        $date_encaissement_cheque = $request->input('date_encaissement_cheque');
        $date_1er_acte = $request->input('date_1er_acte');
        $nature_cheque = $request->input('nature_cheque');
        $travaux_sur_devis = $request->input('travaux_sur_devis');
        $situation_cheque = $request->input('situation_cheque');
        $observation = $request->input('observation');
        $m_h_cheques = new H_Cheque();
        $m_h_cheques->code_u = Auth::user()->code_u;
        $m_h_cheques->id_devis = $id_devis;

        // Appeler la méthode de modification du modèle
        $m_cheque = InfoCheque::modifierCheque(
            $m_h_cheques,
            $id_devis,
            $numero_cheque,
            $montant_cheque,
            $nom_document,
            $date_encaissement_cheque,
            $date_1er_acte,
            $nature_cheque,
            $travaux_sur_devis,
            $situation_cheque,
            $observation
        );
        $m_h_cheques->nom = Auth::user()->prenom . ' ' . Auth::user()->nom;
        $m_h_cheques->dossier = $dossier;
        $m_h_cheques->save();

        //print($dossier.' fd');
        // Retourner une réponse ou rediriger
        return redirect()->to($dossier."/cheque/{$m_cheque->id_devis}/acte{$id_acte}/detail")->with('success', 'Chèque mis à jour avec succès');
    }
    public function showModifierCheque($dossier, $id_devis, $id_acte)
    {
        $data['v_cheque'] = V_Cheque::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        $data['nature_cheques'] = InfoChequeNatureCheque::where('is_deleted', 0)->where('nature_cheque','!=','')->get();
        $data['travaux_sur_devis'] = InfoChequeTravauxDevis::where('is_deleted', 0)->where('travaux_sur_devis','!=','')->get();
        $data['situation_cheques'] = InfoChequeSituationCheque::where('is_deleted', 0)->where('situation_cheque','!=','')->get();
        $data['id_acte'] = $id_acte;
        return view('dossier/cheque/modifier/cheque-modifier')->with($data);
    }
    public function showCheque($dossier, $id_devis, $id_acte)
    {
        $data['v_cheque'] = V_Cheque::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        $data['hists'] = H_Cheque::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->orderBy('created_at', 'desc')
            ->limit(7)
            ->get();
        $data['id_acte'] = $id_acte;
        return view('dossier/cheque/cheque')->with($data);
    }
}
