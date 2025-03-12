<?php

namespace App\Http\Controllers\Anomalie;

use App\Http\Controllers\Controller;
use App\Models\views\V_CaActesReglement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnomalieCaController extends Controller
{
    //
    public function showAnomalieCa()
    {
        $data['ca_actes_reglements'] = V_CaActesReglement::
            where('cotation_paye', '>', DB::raw('COALESCE(cotation, 0)'))
            ->orWhere('ro_part_secu_paye', '>', DB::raw('COALESCE(ro_part_secu, 0)'))
            ->orWhere('part_mutuelle_paye', '>', DB::raw('COALESCE(part_mutuelle, 0)'))
            ->orWhere('rac_part_patient_paye', '>', DB::raw('COALESCE(rac_part_patient, 0)'))
            ->paginate(15);
        return view('anomalies/anomalie-ca')->with($data);
    }
}
