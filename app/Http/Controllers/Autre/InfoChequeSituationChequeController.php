<?php

namespace App\Http\Controllers\Autre;

use App\Http\Controllers\Controller;
use App\Models\devis\cheque\InfoChequeSituationCheque;
use Illuminate\Http\Request;

class InfoChequeSituationChequeController extends Controller
{
    //
    public function showSituationCheque()
    {
        $data['datas'] = InfoChequeSituationCheque::where('is_deleted', 0)->where('situation_cheque', '!=', '')->get();
        return view('autres/info-cheque/situation-cheque')->with($data);
    }
}
