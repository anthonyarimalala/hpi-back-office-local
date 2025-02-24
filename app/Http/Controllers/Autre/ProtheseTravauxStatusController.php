<?php

namespace App\Http\Controllers\Autre;

use App\Http\Controllers\Controller;
use App\Models\devis\prothese\ProtheseTravaux;
use App\Models\devis\prothese\ProtheseTravauxStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProtheseTravauxStatusController extends Controller
{
    //
    public function deleteProtheseTravauxStatus(Request $request)
    {
        $id_status_pose = $request->input('id_status_pose');
        DB::UPDATE('UPDATE prothese_travaux_status SET is_deleted = 1 WHERE id = ?', [$id_status_pose]);
        return back();
    }
    public function saveProtheseTravauxStatus(Request $request)
    {
        $status_pose = $request->input('status_pose');
        $m_prothese_travaux_status = ProtheseTravauxStatus::firstOrNew(['travaux_status'=> $status_pose]);
        $m_prothese_travaux_status->is_deleted = 0;
        $m_prothese_travaux_status->save();
        return back();
    }
    public function showProtheseTravauxStatus(){
        $data['statuss'] = ProtheseTravauxStatus::where('is_deleted', 0)->where('travaux_status', '!=', '')->get();
        return view('autres/status-pose')->with($data);
    }
}
