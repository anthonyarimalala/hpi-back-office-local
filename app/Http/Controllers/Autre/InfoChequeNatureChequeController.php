<?php

namespace App\Http\Controllers\Autre;

use App\Http\Controllers\Controller;
use App\Models\devis\cheque\InfoChequeNatureCheque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoChequeNatureChequeController extends Controller
{
    //
    public function deleteNatureCheque($nature_cheque_){
        DB::update('UPDATE info_cheques_nature_cheques SET is_deleted=1 WHERE nature_cheque=?',[$nature_cheque_]);
        return back();
    }
    public function saveNatureCheque(Request $request){
        $nature_cheque = $request->input('nature_cheque');
        $m_nature = InfoChequeNatureCheque::firstOrNew(['nature_cheque' => $nature_cheque]);
        $m_nature->is_deleted = 0;
        $m_nature->save();
        return back();
    }
    public function showNatureCheque(){
        $data['datas'] = InfoChequeNatureCheque::where('is_deleted', 0)->where('nature_cheque', '!=', '')->get();
        return view('autres/info-cheque/nature-cheque')->with($data);
    }
}
