<?php

namespace App\Http\Controllers\Dossier\Prothese;

use App\Http\Controllers\Controller;
use App\Models\ca\CaGeneral;
use App\Models\devis\Devis;
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
    public function nouveauActe(Request $request, $dossier, $id_devis){
        $id_devis = $request->input('id_devis');
        $laboratoire = $request->input('laboratoire');
        $dateEmpreinte = $request->input('date_empreinte');
        $dateEnvoiLabo = $request->input('date_envoi_labo');
        $travailDemande = $request->input('travail_demande');
        $montant_acte = $request->input('montant_acte');
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

        $m_h_prothese = new H_Prothese();
        $m_h_prothese->code_u = Auth::user()->code_u;
        $m_h_prothese->id_devis = $id_devis;

        echo '$id_devis = '.$id_devis.'<br>';


        $empreinte = ProtheseEmpreinte::createEmpreinte($m_h_prothese, $id_devis, $laboratoire, $dateEmpreinte, $dateEnvoiLabo, $travailDemande, $montant_acte, $numeroDent, $observations, $withChangeProthese);
        ProtheseRetourLabo::createOrUpdateEmpreinte($m_h_prothese, $empreinte->id, $dateLivraison, $numeroSuivi, $numeroFactureLabo, $withChangeProthese);
        ProtheseTravaux::createOrUpdateTravaux($m_h_prothese, $empreinte->id, $datePosePrevue, $id_pose_statut, $datePoseReel, $organismePayeur, $montantEncaisse, $dateControlePaiement, $withChangeProthese);

        $m_h_prothese->nom = Auth::user()->prenom . ' ' . Auth::user()->nom;
        $m_h_prothese->dossier = $dossier;
        if($withChangeProthese){
            $m_h_prothese->save();
        }

        return redirect($dossier.'/prothese/'.$id_devis.'/acte'.$empreinte->id.'/detail');
    }
    public function showNouveauActe($dossier, $id_devis, $id_acte){
        $m_prothese_empreinte = ProtheseEmpreinte::where('id_devis', $id_devis)->first();
        if($m_prothese_empreinte == null){
            return back()->withErrors(['error' => 'Il n\'y a aucun travail demandé dans ce devis. Cliquez d\'abord sur "Modifier" sur modifier et si\'il y\'a encore d\'autres travails à faire vous pouvez cliquer sur "Nouveau Acte".']);
        }else if($m_prothese_empreinte->travail_demande == ''){
            return back()->withErrors(['error' => 'Mettez d\'abord un nom dans l\'acte(travail demandé)']);
        }
        $data['id_acte'] = $id_acte;
        $data['m_devis'] = Devis::where('id', $id_devis)->first();
        $data['m_prothese_empreinte'] = ProtheseEmpreinte::find($id_acte);
        $data['status_poses'] = ProtheseTravauxStatus::where('is_deleted', '0')->where('travaux_status', '!=', '')->get();
        return view('dossier/prothese/nouveau/nouveau-acte')->with($data);
    }
    public function modifierProthese(Request $request, $id_acte){
        $dossier = $request->input('dossier');
        $id_devis = $request->input('id_devis');
        $laboratoire = $request->input('laboratoire');
        $dateEmpreinte = $request->input('date_empreinte');
        $dateEnvoiLabo = $request->input('date_envoi_labo');
        $travailDemande = $request->input('travail_demande');
        $montant_acte = $request->input('montant_acte');
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

        ProtheseEmpreinte::createOrUpdateEmpreinte($m_h_prothese, $id_devis, $id_acte, $laboratoire, $dateEmpreinte, $dateEnvoiLabo, $travailDemande, $montant_acte, $numeroDent, $observations, null, $withChangeProthese);
        ProtheseRetourLabo::createOrUpdateEmpreinte($m_h_prothese, $id_acte, $dateLivraison, $numeroSuivi, $numeroFactureLabo, $withChangeProthese);
        ProtheseTravaux::createOrUpdateTravaux($m_h_prothese, $id_acte, $datePosePrevue, $id_pose_statut, $datePoseReel, $organismePayeur, $montantEncaisse, $dateControlePaiement, $withChangeProthese);

        $m_h_prothese->nom = Auth::user()->prenom . ' ' . Auth::user()->nom;
        $m_h_prothese->dossier = $dossier;
        if($withChangeProthese){
            $m_h_prothese->save();
        }
        return redirect()->to($dossier."/prothese/".$id_devis."/acte".$id_acte."/detail");
    }
    public function showModifierProthese($dossier, $id_devis, $id_acte){
        $data['id_acte'] = $id_acte;
        $data['v_prothese'] = V_Prothese::where('dossier', $dossier)
            ->where('id_acte', $id_acte)
            ->first();
        $data['status_poses'] = ProtheseTravauxStatus::where('is_deleted', '0')->where('travaux_status', '!=', '')->get();
        return view('dossier/prothese/modifier/prothese-modifier')->with($data);
    }
    public function showProthese($dossier, $id_devis, $id_acte){
        $data['v_prothese'] = V_Prothese::where('dossier', $dossier)
            ->where('id_acte', $id_acte)
            ->first();
        $data['hists'] = H_Prothese::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->orderBy('created_at', 'desc')
            ->limit(7)
            ->get();
        $data['id_acte'] = $id_acte;
        return view('dossier/prothese/prothese')->with($data);
    }
}
