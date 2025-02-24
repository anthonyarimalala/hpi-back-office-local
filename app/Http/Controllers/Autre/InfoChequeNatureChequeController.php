<?php

namespace App\Http\Controllers\Autre;

use App\Http\Controllers\Controller;
use App\Models\devis\cheque\InfoChequeNatureCheque;
use Illuminate\Http\Request;

class InfoChequeNatureChequeController extends Controller
{
    //
    public function showNatureCheque(){
        $data['datas'] = InfoChequeNatureCheque::where('is_deleted', 0)->where('nature_cheque', '!=', '')->get();
        return view('autres/info-cheque/nature-cheque')->with($data);
    }
}
