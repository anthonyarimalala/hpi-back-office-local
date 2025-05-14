<?php

namespace App\Models\ca;

use App\Models\hist\H_CaActesReglement;
use App\Models\views\V_CaActesReglement;
use App\Models\views\V_Devis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class L_CaActesReglement extends Model
{
    use HasFactory;
    protected $table = 'l_ca_actes_reglements';
    protected $fillable = [
        'id_ca',
        'id_acte',
        'praticien',
        'date_derniere_modif',
        'nom_acte',
        'cotation',
        'controle_securisation',
        'ro_part_secu',
        'ro_virement_recu',
        'ro_indus_paye',
        'ro_indus_en_attente',
        'ro_indus_irrecouvrable',
        'part_mutuelle',
        'rcs_virement',
        'rcs_especes',
        'rcs_cb',
        'rcsd_cheque',
        'rcsd_especes',
        'rcsd_cb',
        'rac_part_patient',
        'rac_cheque',
        'rac_especes',
        'rac_cb',
        'commentaire',
        'created_at',
    ];

    public static function createCaAfterDevis($id_devis, $id_acte, $acte, $montant_acte, $date_devis, $changement_praticien=true, $changement_acte=true, $changement_montant = true){

        $ca_generale = CaGeneral::where('id_devis', $id_devis)->first();
        $devis = V_Devis::where('id_devis', $id_devis)->first();
        // raha manao import de ndraindray tsy hita ilay id_devis amle CA Generale
        if (!$ca_generale) {
            // andramana tedavina am date sy ny tariny
            $ca_generale = CaGeneral::where('dossier', $devis->dossier)
            ->where('statut', $devis->status)
            ->where(function ($query) use ($devis) {
                $query->where('mutuelle', $devis->mutuelle)
                      ->orWhereNull('mutuelle');
            })
            ->whereDate('created_at',  $date_devis)
            ->first();
            // rehefa tena tsy hita de mamorona vaovao
            if (!$ca_generale)
            {
                $ca_generale = new CaGeneral();
                $ca_generale->dossier = $devis->dossier;
                $ca_generale->nom_patient = $devis->nom;
                $ca_generale->statut = $devis->status;
                $ca_generale->mutuelle = $devis->mutuelle;
                $ca_generale->created_at = $date_devis;
            }
            $ca_generale->id_devis = $id_devis;
            $ca_generale->save();
        }
        $ca = L_CaActesReglement::where('id_acte', $id_acte)
            ->first();
        if(!$ca){
            $ca = L_CaActesReglement::where('id_ca', $ca_generale->id)
                ->where('id_acte', $id_acte)
                ->where('praticien',$devis->praticien)
                ->where('nom_acte', $devis->travail_demande)
                ->first();

            if(!$ca){
                $ca = new L_CaActesReglement();

            }
        }
        $ca->id_acte = $id_acte;
        $ca->created_at = $date_devis;
        $ca->id_ca = $ca_generale->id;
        if($changement_praticien){
            $ca->praticien = $devis->praticien;
        }
        if($changement_acte){
            $ca->nom_acte = $acte;
        }
        if($changement_montant){
            $ca->cotation = $montant_acte === '' ? null : $montant_acte;
        }


        $ca->save();
    }

    public static function updateCaActesReglement(Request $request, $id_ca_actes_reglement){
        $date_derniere_modif = $request->input('date_derniere_modif');
        $praticien = $request->input('praticien');
        $nom_acte = $request->input('nom_acte');
        $cotation = $request->input('cotation');
        $controle_securisation = $request->input('controle_securisation');
        $ro_part_secu = $request->input('ro_part_secu');
        $ro_virement_recu = $request->input('ro_virement_recu');
        $ro_indus_paye = $request->input('ro_indus_paye');
        $ro_indus_en_attente = $request->input('ro_indus_en_attente');
        $ro_indus_irrecouvrable = $request->input('ro_indus_irrecouvrable');
        $part_mutuelle = $request->input('part_mutuelle');
        $rcs_virement = $request->input('rcs_virement');
        $rcs_especes = $request->input('rcs_especes');
        $rcs_cb = $request->input('rcs_cb');
        $rcsd_cheque = $request->input('rcsd_cheque');
        $rcsd_especes = $request->input('rcsd_especes');
        $rcsd_cb = $request->input('rcsd_cb');
        $rac_part_patient = $request->input('rac_part_patient');
        $rac_cheque = $request->input('rac_cheque');
        $rac_especes = $request->input('rac_especes');
        $rac_cb = $request->input('rac_cb');
        $commentaire = $request->input('commentaire');

        if ($date_derniere_modif == null || $date_derniere_modif == '') {
            $date_derniere_modif = Carbon::parse()->format('Y-m-d H:i');
        }

        $m_ca = V_CaActesReglement::where('id_ca_actes_reglement', $id_ca_actes_reglement)->first();
        $haveChange = false;
        $m_h_ca = new H_CaActesReglement();
        $m_h_ca->code_u =Auth::user()->code_u;
        $m_h_ca->nom = Auth::user()->prenom. ' '. Auth::user()->nom;
        $m_h_ca->id_ca_actes_reglement = $id_ca_actes_reglement;
        $m_h_ca->dossier = $m_ca->dossier;

        $m_l_ca_actes_reglement = L_CaActesReglement::where('id', $id_ca_actes_reglement)->first();
        $m_l_ca_actes_reglement->date_derniere_modif = $date_derniere_modif;
        $m_l_ca_actes_reglement->praticien = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "praticien", $m_l_ca_actes_reglement->praticien, $praticien);
        $m_l_ca_actes_reglement->nom_acte = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "acte", $m_l_ca_actes_reglement->nom_acte, $nom_acte);
        $m_l_ca_actes_reglement->cotation = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "cotation", $m_l_ca_actes_reglement->cotation, $cotation);
        $m_l_ca_actes_reglement->controle_securisation = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "controle_securisation", $m_l_ca_actes_reglement->controle_securisation, $controle_securisation);
        $m_l_ca_actes_reglement->ro_part_secu = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "ro_part_secu", $m_l_ca_actes_reglement->ro_part_secu, $ro_part_secu);
        $m_l_ca_actes_reglement->ro_virement_recu = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "ro_virement_recu", $m_l_ca_actes_reglement->ro_virement_recu, $ro_virement_recu);
        $m_l_ca_actes_reglement->ro_indus_paye = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "ro_indus_paye", $m_l_ca_actes_reglement->ro_indus_paye, $ro_indus_paye);
        $m_l_ca_actes_reglement->ro_indus_en_attente = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "ro_indus_en_attente", $m_l_ca_actes_reglement->ro_indus_en_attente, $ro_indus_en_attente);
        $m_l_ca_actes_reglement->ro_indus_irrecouvrable = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "ro_indus_irrecouvrable", $m_l_ca_actes_reglement->ro_indus_irrecouvrable, $ro_indus_irrecouvrable);
        $m_l_ca_actes_reglement->part_mutuelle = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "part_mutuelle", $m_l_ca_actes_reglement->part_mutuelle, $part_mutuelle);
        $m_l_ca_actes_reglement->rcs_virement = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rcs_virement", $m_l_ca_actes_reglement->rcs_virement, $rcs_virement);
        $m_l_ca_actes_reglement->rcs_especes = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rcs_especes", $m_l_ca_actes_reglement->rcs_especes, $rcs_especes);
        $m_l_ca_actes_reglement->rcs_cb = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rcs_cb", $m_l_ca_actes_reglement->rcs_cb, $rcs_cb);
        $m_l_ca_actes_reglement->rcsd_cheque = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rcsd_cheque", $m_l_ca_actes_reglement->rcsd_cheque, $rcsd_cheque);
        $m_l_ca_actes_reglement->rcsd_especes = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rcsd_especes", $m_l_ca_actes_reglement->rcsd_especes, $rcsd_especes);
        $m_l_ca_actes_reglement->rcsd_cb = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rcsd_cb", $m_l_ca_actes_reglement->rcsd_cb, $rcsd_cb);
        $m_l_ca_actes_reglement->rac_part_patient = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rac_part_patient", $m_l_ca_actes_reglement->rac_part_patient, $rac_part_patient);
        $m_l_ca_actes_reglement->rac_cheque = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rac_cheque", $m_l_ca_actes_reglement->rac_cheque, $rac_cheque);
        $m_l_ca_actes_reglement->rac_especes = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rac_especes", $m_l_ca_actes_reglement->rac_especes, $rac_especes);
        $m_l_ca_actes_reglement->rac_cb = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rac_cb", $m_l_ca_actes_reglement->rac_cb, $rac_cb);
        $m_l_ca_actes_reglement->commentaire = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "commentaire", $m_l_ca_actes_reglement->commentaire, $commentaire);
        $m_l_ca_actes_reglement->save();
        if($haveChange){
            $m_h_ca->id_ca_actes_reglement = $m_l_ca_actes_reglement->id;
            $m_h_ca->save();
        }
        //echo 'haveChange= '.$haveChange;
        return $m_l_ca_actes_reglement;
    }
    public static function insertCaActesReglement(Request $request, $id_ca){
        $date_derniere_modif = $request->input('date_derniere_modif');
        $praticien = $request->input('praticien');
        $nom_acte = $request->input('nom_acte');
        $cotation = $request->input('cotation');
        $controle_securisation = $request->input('controle_securisation');
        $ro_part_secu = $request->input('ro_part_secu');
        $ro_virement_recu = $request->input('ro_virement_recu');
        $ro_indus_paye = $request->input('ro_indus_paye');
        $ro_indus_en_attente = $request->input('ro_indus_en_attente');
        $ro_indus_irrecouvrable = $request->input('ro_indus_irrecouvrable');
        $part_mutuelle = $request->input('part_mutuelle');
        $rcs_virement = $request->input('rcs_virement');
        $rcs_especes = $request->input('rcs_especes');
        $rcs_cb = $request->input('rcs_cb');
        $rcsd_cheque = $request->input('rcsd_cheque');
        $rcsd_especes = $request->input('rcsd_especes');
        $rcsd_cb = $request->input('rcsd_cb');
        $rac_part_patient = $request->input('rac_part_patient');
        $rac_cheque = $request->input('rac_cheque');
        $rac_especes = $request->input('rac_especes');
        $rac_cb = $request->input('rac_cb');
        $commentaire = $request->input('commentaire');

        if ($date_derniere_modif == null) {
            $date_derniere_modif = Carbon::parse()->format('Y-m-d');
        }

        $v_ca = V_CaActesReglement::where('id_ca', $id_ca)->first();

        $m_h_ca = new H_CaActesReglement();
        $m_h_ca->code_u = Auth::user()->code_u;
        $m_h_ca->nom = Auth::user()->prenom. ' '. Auth::user()->nom;
        $m_h_ca->id_ca_actes_reglement = $id_ca;
        $m_h_ca->dossier = $v_ca->dossier;
        $m_h_ca->action .= "<strong>Nouveau Acte</strong><br>";
        $haveChange = true;

        $m_l_ca_actes_reglement = new L_CaActesReglement();
        $m_l_ca_actes_reglement->id_ca = $id_ca;
        $m_l_ca_actes_reglement->date_derniere_modif = $date_derniere_modif;
        $m_l_ca_actes_reglement->praticien = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "praticien", $m_l_ca_actes_reglement->praticien, $praticien);
        $m_l_ca_actes_reglement->nom_acte = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "acte", $m_l_ca_actes_reglement->nom_acte, $nom_acte);
        $m_l_ca_actes_reglement->cotation = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "cotation", $m_l_ca_actes_reglement->cotation, $cotation);
        $m_l_ca_actes_reglement->controle_securisation = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "controle_securisation", $m_l_ca_actes_reglement->controle_securisation, $controle_securisation);
        $m_l_ca_actes_reglement->ro_part_secu = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "ro_part_secu", $m_l_ca_actes_reglement->ro_part_secu, $ro_part_secu);
        $m_l_ca_actes_reglement->ro_virement_recu = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "ro_virement_recu", $m_l_ca_actes_reglement->ro_virement_recu, $ro_virement_recu);
        $m_l_ca_actes_reglement->ro_indus_paye = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "ro_indus_paye", $m_l_ca_actes_reglement->ro_indus_paye, $ro_indus_paye);
        $m_l_ca_actes_reglement->ro_indus_en_attente = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "ro_indus_en_attente", $m_l_ca_actes_reglement->ro_indus_en_attente, $ro_indus_en_attente);
        $m_l_ca_actes_reglement->ro_indus_irrecouvrable = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "ro_indus_irrecouvrable", $m_l_ca_actes_reglement->ro_indus_irrecouvrable, $ro_indus_irrecouvrable);
        $m_l_ca_actes_reglement->part_mutuelle = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "part_mutuelle", $m_l_ca_actes_reglement->part_mutuelle, $part_mutuelle);
        $m_l_ca_actes_reglement->rcs_virement = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rcs_virement", $m_l_ca_actes_reglement->rcs_virement, $rcs_virement);
        $m_l_ca_actes_reglement->rcs_especes = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rcs_especes", $m_l_ca_actes_reglement->rcs_especes, $rcs_especes);
        $m_l_ca_actes_reglement->rcs_cb = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rcs_cb", $m_l_ca_actes_reglement->rcs_cb, $rcs_cb);
        $m_l_ca_actes_reglement->rcsd_cheque = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rcsd_cheque", $m_l_ca_actes_reglement->rcsd_cheque, $rcsd_cheque);
        $m_l_ca_actes_reglement->rcsd_especes = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rcsd_especes", $m_l_ca_actes_reglement->rcsd_especes, $rcsd_especes);
        $m_l_ca_actes_reglement->rcsd_cb = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rcsd_cb", $m_l_ca_actes_reglement->rcsd_cb, $rcsd_cb);
        $m_l_ca_actes_reglement->rac_part_patient = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rac_part_patient", $m_l_ca_actes_reglement->rac_part_patient, $rac_part_patient);
        $m_l_ca_actes_reglement->rac_cheque = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rac_cheque", $m_l_ca_actes_reglement->rac_cheque, $rac_cheque);
        $m_l_ca_actes_reglement->rac_especes = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rac_especes", $m_l_ca_actes_reglement->rac_especes, $rac_especes);
        $m_l_ca_actes_reglement->rac_cb = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "rac_cb", $m_l_ca_actes_reglement->rac_cb, $rac_cb);
        $m_l_ca_actes_reglement->commentaire = $m_l_ca_actes_reglement->makeHistoWhenUpdate($m_h_ca, $haveChange, "commentaire", $m_l_ca_actes_reglement->commentaire, $commentaire);
        $m_l_ca_actes_reglement->save();
        $m_h_ca->id_ca_actes_reglement = $m_l_ca_actes_reglement->id;
        $m_h_ca->save();
        return $m_l_ca_actes_reglement;
    }

    public function makeHistoWhenUpdate(&$m_h_ca, &$haveChange, $desc ,$oldValue, $newValue){
        if($oldValue != $newValue){
            $m_h_ca->action .= "<strong>".$desc.": </strong>". $oldValue . " => " .$newValue. "<br>";
            $haveChange = true;
        }
        return $newValue;
    }
}
