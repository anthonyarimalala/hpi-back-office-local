<?php

namespace App\Http\Controllers\Export;

use App\Exports\V_DevisExport;
use App\Http\Controllers\Controller;
use App\Models\views\V_Devis;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportsController extends Controller
{
    //
    public function exportV_Devis()
    {
        $v_devis = V_Devis::all();
        return Excel::download(new V_DevisExport($v_devis), 'v_devis.xlsx');
    }
}
