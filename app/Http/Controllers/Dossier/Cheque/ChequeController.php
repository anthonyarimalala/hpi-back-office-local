<?php

namespace App\Http\Controllers\Dossier\Cheque;

use App\Http\Controllers\Controller;
use App\Models\devis\cheque\InfoCheque;
use App\Models\views\V_Cheque;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    //
    public function modifierCheque(Request $request)
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

        // Appeler la méthode de modification du modèle
        $m_cheque = InfoCheque::modifierCheque(
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

        // Retourner une réponse ou rediriger
        return redirect()->to($dossier."/cheque/{$m_cheque->id_devis}/detail")->with('success', 'Chèque mis à jour avec succès');
    }
    public function showModifierCheque($dossier, $id_devis)
    {
        $data['v_cheque'] = V_Cheque::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        return view('dossier/cheque/modifier/cheque-modifier')->with($data);
    }
    public function showCheque($dossier, $id_devis)
    {
        $data['v_cheque'] = V_Cheque::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        return view('dossier/cheque/cheque')->with($data);
    }
}
