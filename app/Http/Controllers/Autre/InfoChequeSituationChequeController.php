<?php

namespace App\Http\Controllers\Autre;

use App\Http\Controllers\Controller;
use App\Models\devis\cheque\InfoChequeSituationCheque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoChequeSituationChequeController extends Controller
{
    //

    public function deleteSituationCheque($situation_cheque_){
        DB::update('UPDATE info_cheques_situation_cheques SET is_deleted=1 WHERE situation_cheque=?',[$situation_cheque_]);
        return back();
    }
    public function saveSituationCheque(Request $request){
        $situation_cheque = $request->input('situation_cheque');
        $m_situation = InfoChequeSituationCheque::firstOrNew(['nature_cheque' => $situation_cheque]);
        $m_situation->is_deleted = 0;
        $m_situation->save();
        return back();
    }
    public function showSituationCheque()
    {
        $data['datas'] = InfoChequeSituationCheque::where('is_deleted', 0)->where('situation_cheque', '!=', '')->get();
        return view('autres/info-cheque/situation-cheque')->with($data);
    }
}
