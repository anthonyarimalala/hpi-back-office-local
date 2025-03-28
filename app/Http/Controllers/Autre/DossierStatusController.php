<?php

namespace App\Http\Controllers\Autre;

use App\Http\Controllers\Controller;
use App\Models\dossier\DossierStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DossierStatusController extends Controller
{
    //
    public function deleteDossierStatus(Request $request)
    {
        $status_ = $request->input('status');
        $m_status = DossierStatus::find($status_);
        $m_status->is_deleted = 1;
        $m_status->save();
        /*
        if ($status_ != 'C2S') {

            DB::update('UPDATE dossier_statuss SET is_deleted = 1 WHERE status = ?', [$status_]);
        }else{
            DB::update('UPDATE dossier_statuss SET is_deleted = 1, ordre = 10 WHERE status = ?', [$status_]);
        }
        */

        return back();
    }
    public function saveDossierStatus(Request $request)
    {
        $status_ = $request->input('status');
        $signification = $request->input('signification');

        // Vérifie si un statut avec le même "status" existe déjà
        $dossierStatus = DossierStatus::find($status_);

        if ($dossierStatus) {
            // Si le statut existe, on met à jour les informations
            $dossierStatus->signification = $signification;
            $dossierStatus->is_deleted = 0;  // Restaure le statut si supprimé
        } else {
            // Si le statut n'existe pas, on crée un nouveau statut
            $dossierStatus = new DossierStatus();
            $dossierStatus->status = $status_;
            $dossierStatus->signification = $signification;
            $dossierStatus->is_deleted = 0;  // Par défaut, le statut est actif
        }

        // Sauvegarde dans la base de données
        $dossierStatus->save();
        return back();
    }


    public function showDossierStatus(){
        $data['dossier_statuss'] = DossierStatus::where('is_deleted', 0)
            ->where('status', '!=', '')
            ->get();
        return view('autres/status')->with($data);
    }
}
