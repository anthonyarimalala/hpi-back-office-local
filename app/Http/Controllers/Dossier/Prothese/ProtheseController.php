<?php

namespace App\Http\Controllers\Dossier\Prothese;

use App\Http\Controllers\Controller;
use App\Models\devis\prothese\ProtheseEmpreinte;
use App\Models\devis\prothese\ProtheseRetourLabo;
use App\Models\devis\prothese\ProtheseTravaux;
use App\Models\views\V_Cheque;
use App\Models\views\V_Prothese;
use Illuminate\Http\Request;

class ProtheseController extends Controller
{
    //
    public function modifierProthese(Request $request){
        $dossier = $request->input('dossier');
        $id_devis = $request->input('id_devis');
        $laboratoire = $request->input('laboratoire');
        $dateEmpreinte = $request->input('date_empreinte');
        $dateEnvoiLabo = $request->input('date_envoi_labo');
        $travailDemande = $request->input('travail_demande');
        $numeroDent = $request->input('numero_dent');
        $observations = $request->input('observations');
        $dateLivraison = $request->input('date_livraison');
        $numeroSuivi = $request->input('numero_suivi');
        $numeroFactureLabo = $request->input('numero_facture_labo');
        $datePosePrevue = $request->input('date_pose_prevue');
        $statut = $request->input('statut');
        $datePoseReel = $request->input('date_pose_reel');
        $organismePayeur = $request->input('organisme_payeur');
        $montantEncaisse = $request->input('montant_encaisse');
        $dateControlePaiement = $request->input('date_controle_paiement');
        //print($dateLivraison);

        ProtheseEmpreinte::createOrUpdateEmpreinte($id_devis, $laboratoire, $dateEmpreinte, $dateEnvoiLabo, $travailDemande, $numeroDent, $observations);
        ProtheseRetourLabo::createOrUpdateEmpreinte($id_devis, $dateLivraison, $numeroSuivi, $numeroFactureLabo);
        ProtheseTravaux::createOrUpdateTravaux($id_devis, $datePosePrevue, $statut, $datePoseReel, $organismePayeur, $montantEncaisse, $dateControlePaiement);
        return redirect()->to($dossier."/prothese/".$id_devis."/detail");

    }
    public function showModifierProthese($dossier, $id_devis){
        $data['v_prothese'] = V_Prothese::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        return view('dossier/prothese/modifier/prothese-modifier')->with($data);
    }
    public function showProthese($dossier, $id_devis){
        $data['v_prothese'] = V_Prothese::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        return view('dossier/prothese/prothese')->with($data);
    }
}
