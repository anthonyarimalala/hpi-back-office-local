<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReinitializeController extends Controller
{
    //
    // redirigé vers export devis pour au moins exporter les données avant d'effacer
    public static function effacerCA($l_ca_actes_reglements_ids) {
        // 1. Supprimer les actes
        DB::table('l_ca_actes_reglements')
            ->whereIn('id', $l_ca_actes_reglements_ids)
            ->delete();

        // 2. Supprimer les ca_generales orphelins
        DB::table('ca_generales')
            ->whereNotIn('id', function($query) {
                $query->select('id_ca')->from('l_ca_actes_reglements');
            })
            ->delete();
    }

    public static function effacerDevis($devis_ids){
        if ($devis_ids->isNotEmpty()) {
            // Supprimer dans les tables enfants
            DB::table('protheses')->whereIn('id_devis', $devis_ids)->delete();
            DB::table('info_cheques')->whereIn('id_devis', $devis_ids)->delete();
            DB::table('devis_appels_et_mails')->whereIn('id_devis', $devis_ids)->delete();
            DB::table('devis_reglements')->whereIn('id_devis', $devis_ids)->delete();
            DB::table('devis_accord_pecs')->whereIn('id_devis', $devis_ids)->delete();

            // Supprimer les devis eux-mêmes
            DB::table('devis')->whereIn('id', $devis_ids)->delete();
        }
    }
    public function showReinitialisePage(){
        $data['devis_filters'] = session()->get('devis_filters', []);
        $data['ca_filters'] = session()->get('ca_filters', []);
        return view('reinitialise/reinitialiser')->with($data);
    }

    public function reinitialiseAll(){
        DB::delete("DELETE FROM prothese_travaux");
        DB::delete("DELETE FROM prothese_retour_labos");
        DB::delete("DELETE FROM prothese_empreintes");
        DB::delete("DELETE FROM info_cheques");
        DB::delete("DELETE FROM devis_appels_et_mails");
        DB::delete("DELETE FROM devis_reglements");
        DB::delete("DELETE FROM devis_accord_pecs");
        DB::delete("DELETE FROM l_ca_actes_reglements");
        DB::delete("DELETE FROM ca_generales");
        DB::delete("DELETE FROM devis");
        DB::delete("DELETE FROM dossiers");
        return back();
    }
}
