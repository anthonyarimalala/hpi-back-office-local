<?php

namespace App\Http\Controllers\Dossier\Cheque;

use App\Http\Controllers\Controller;
use App\Models\views\V_Cheque;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    //
    public function showCheque($dossier, $id_devis)
    {
        $data['v_cheque'] = V_Cheque::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        return view('dossier/cheque/cheque')->with($data);
    }
}
