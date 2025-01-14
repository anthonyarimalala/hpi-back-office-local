<?php

namespace App\Http\Controllers\Dossier\Prothese;

use App\Http\Controllers\Controller;
use App\Models\views\V_Cheque;
use Illuminate\Http\Request;

class ProtheseController extends Controller
{
    //
    public function showProthese($dossier, $id_devis){
        $data['v_prothese'] = V_Cheque::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        return view('dossier/prothese/prothese')->with($data);
    }
}
