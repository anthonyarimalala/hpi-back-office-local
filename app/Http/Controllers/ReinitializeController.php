<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReinitializeController extends Controller
{
    //
    public function reinitializeAll(){
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
