<?php

namespace App\Http\Controllers\Autre;

use App\Http\Controllers\Controller;
use App\Models\devis\cheque\InfoChequeTravauxDevis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoChequeTravauxDevisController extends Controller
{
    //
    public function saveTravauxDevis(Request $request){
        $travaux_devis = $request->input('travaux_devis');
        $m_travaux_devis = InfoChequeTravauxDevis::firstOrNew(['travaux_sur_devis' => $travaux_devis]);
        $m_travaux_devis->is_deleted = 0;
        $m_travaux_devis->save();
        return back();
    }
    public function deleteTravauxDevis($travaux_sur_devis){
        DB::delete("UPDATE info_cheques_travaux_sur_devis SET is_deleted = ? WHERE travaux_sur_devis=?", [1, $travaux_sur_devis]);
        return back();
    }
    public function showTravauxDevis(){
        $data['datas'] = InfoChequeTravauxDevis::where('is_deleted', 0)->where('travaux_sur_devis', '!=', '')->get();
        return view('autres/info-cheque/travaux-devis')->with($data);
    }
}
