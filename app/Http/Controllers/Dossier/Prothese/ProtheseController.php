<?php

namespace App\Http\Controllers\Dossier\Prothese;

use App\Http\Controllers\Controller;
use App\Models\devis\prothese\ProtheseEmpreinte;
use App\Models\devis\prothese\ProtheseRetourLabo;
use App\Models\devis\prothese\ProtheseTravaux;
use App\Models\devis\prothese\ProtheseTravauxStatus;
use App\Models\dossier\Dossier;
use App\Models\hist\H_Prothese;
use App\Models\views\V_Cheque;
use App\Models\views\V_Prothese;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProtheseController extends Controller
{
    //
    public function showNouveauActe($dossier, $id_devis){
        $m_prothese_empreinte = ProtheseEmpreinte::where('id_devis', $id_devis)->first();
        if($m_prothese_empreinte == null){
            return back()->withErrors(['error' => 'Il n\'y a aucun travail demandé dans ce devis. Cliquez d\'abord sur "Modifier" sur modifier et si\'il y\'a encore d\'autres travails à faire vous pouvez cliquer sur "Nouveau Acte".']);
        }else if($m_prothese_empreinte->travail_demande == ''){
            return back()->withErrors(['error' => 'Mettez d\'abord un nom dans le 1er acte(travail demandé)']);
        }
        $data['m_dossier'] = Dossier::where('dossier', $dossier)->first();
        $data['status_poses'] = ProtheseTravauxStatus::where('is_deleted', '0')->where('travaux_status', '!=', '')->get();
        return view()->with($data);
    }
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
        $id_pose_statut = $request->input('id_pose_statut');
        $datePoseReel = $request->input('date_pose_reel');
        $organismePayeur = $request->input('organisme_payeur');
        $montantEncaisse = $request->input('montant_encaisse');
        $dateControlePaiement = $request->input('date_controle_paiement');
        //print($dateLivraison);
        $m_h_prothese = new H_Prothese();
        $m_h_prothese->code_u = Auth::user()->code_u;
        $m_h_prothese->id_devis = $id_devis;

        ProtheseEmpreinte::createOrUpdateEmpreinte($m_h_prothese, $id_devis, $laboratoire, $dateEmpreinte, $dateEnvoiLabo, $travailDemande, $numeroDent, $observations, $withChangeProthese);
        ProtheseRetourLabo::createOrUpdateEmpreinte($m_h_prothese, $id_devis, $dateLivraison, $numeroSuivi, $numeroFactureLabo, $withChangeProthese);
        ProtheseTravaux::createOrUpdateTravaux($m_h_prothese, $id_devis, $datePosePrevue, $id_pose_statut, $datePoseReel, $organismePayeur, $montantEncaisse, $dateControlePaiement, $withChangeProthese);

        $m_h_prothese->nom = Auth::user()->prenom . ' ' . Auth::user()->nom;
        $m_h_prothese->dossier = $dossier;
        if($withChangeProthese){
            $m_h_prothese->save();
        }
        return redirect()->to($dossier."/prothese/".$id_devis."/detail");
    }
    public function showModifierProthese($dossier, $id_devis){
        $data['v_prothese'] = V_Prothese::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        $data['status_poses'] = ProtheseTravauxStatus::where('is_deleted', '0')->where('travaux_status', '!=', '')->get();
        return view('dossier/prothese/modifier/prothese-modifier')->with($data);
    }
    public function showProthese($dossier, $id_devis){
        $data['v_prothese'] = V_Prothese::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        $data['hists'] = H_Prothese::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->orderBy('created_at', 'desc')
            ->limit(7)
            ->get();
        return view('dossier/prothese/prothese')->with($data);
    }
}
