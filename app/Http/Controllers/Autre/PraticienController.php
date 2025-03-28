<?php

namespace App\Http\Controllers\Autre;

use App\Http\Controllers\Controller;
use App\Models\praticien\Praticien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PraticienController extends Controller
{
    //
    public function deletePraticien(Request $request){
        $praticien_ = $request->input('praticien');
        DB::update('UPDATE praticiens SET is_deleted=1 WHERE praticien=?',[$praticien_]);
        return back();
    }
    public function savePraticien(Request $request){
        $praticien_ = $request->input('praticien');
        $nom = $request->input('nom');
        $praticien = Praticien::where('praticien', $praticien_)->first();
        if ($praticien){
            $praticien->nom = $nom;
            $praticien->is_deleted = 0;
        }else{
            $praticien = new Praticien();
            $praticien->praticien = $praticien_;
            $praticien->nom = $nom;
            $praticien->is_deleted = 0;
        }
        $praticien->save();
        return back();
    }
    public function showPraticiens()
    {
        $data['praticiens'] = Praticien::where('is_deleted', 0)
            ->where('praticien', '!=', '')
            ->get();
        return view('autres/praticien')->with($data);
    }
}
