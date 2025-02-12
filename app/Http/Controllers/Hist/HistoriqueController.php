<?php

namespace App\Http\Controllers\Hist;

use App\Http\Controllers\Controller;
use App\Models\hist\H_CaActesReglement;
use App\Models\views\V_H_Cheque;
use App\Models\views\V_H_Devis;
use App\Models\views\V_H_Prothese;

class HistoriqueController extends Controller
{
    //
    public function showHistCa()
    {
        $data['hists'] = H_CaActesReglement::orderBy('created_at', 'desc')
            ->paginate(15);
        return view('hist/hist_ca')->with($data);
    }
    public function showHistDevis()
    {
        $data['hists'] = V_H_Devis::orderBy('created_at', 'desc')
            ->paginate(15);
        return view('hist/hist_devis')->with($data);
    }
    public  function showHistProthese()
    {
        $data['hists'] = V_H_Prothese::orderBy('created_at', 'desc')
            ->paginate(15);
        return view('hist/hist_protheses')->with($data);
    }
    public function showHistCheque()
    {
        $data['hists'] = V_H_Cheque::orderBy('created_at', 'desc')
            ->paginate(15);
        return view('hist/hist_cheques')->with($data);
    }
}
