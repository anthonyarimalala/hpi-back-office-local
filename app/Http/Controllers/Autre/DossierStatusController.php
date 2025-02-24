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
        DB::delete('DELETE FROM dossier_statuss WHERE status = ?', [$status_]);
        return back();
    }
    public function saveDossierStatus(Request $request)
    {
        $status_ = $request->input('status');
        $signification = $request->input('signification');
        $ordre = $request->input('ordre', 0);  // Valeur par défaut pour "ordre" est 0

        // Vérifie si un statut avec le même "status" existe déjà
        $dossierStatus = DossierStatus::where('status', $status_)->first();

        if ($dossierStatus) {
            // Si le statut existe, on met à jour les informations
            $dossierStatus->signification = $signification;
            $dossierStatus->ordre = $ordre;
            $dossierStatus->is_deleted = 0;  // Restaure le statut si supprimé
        } else {
            // Si le statut n'existe pas, on crée un nouveau statut
            $dossierStatus = new DossierStatus();
            $dossierStatus->status = $status_;
            $dossierStatus->signification = $signification;
            $dossierStatus->ordre = $ordre;
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
