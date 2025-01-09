<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\dossier\Dossier;
use App\Models\dossier\DossierStatus;
use App\Models\dossier\L_DossierMutuelle;
use App\Models\patient\Patient;
use App\Models\views\V_Dossier;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    //
    // cette fonction se divise en trois parties:
        // insertion patient
        // insertion dossier
        // insertion mutuelle

    public function insertPatient(Request $request)
    {

        $validated = $request->validate([
            'nom' => 'required|string|min:3',
            'date_naissance' => 'required',
        ]);
        $nom = $request->input('nom');
        $date_naissance = $request->input('date_naissance');
        $dossier = $request->input('dossier');
        $status = $request->input('status');
        $mutuelles = $request->input('mutuelle', []);

        $id_patient = Patient::insertPatient($nom, $date_naissance); // insérer le patient
        Dossier::insertDossier($dossier, $id_patient, $status); // insérer son dossier
        foreach ($mutuelles as $mutuelle){
            if($mutuelle != null && $mutuelle != "") L_DossierMutuelle::insertL_DossierMutuelle($dossier, $mutuelle); // insérer les mutuelles
        }

        return redirect()->route('dossiers')->with('success', 'Le patient "'.$nom.'" a été ajouté avec success');
    }
    public function showInsertPatient(Request $request){
        $data['statuss'] = DossierStatus::orderBy('ordre', 'desc')
            ->orderBy('status', 'asc')
            ->where('is_deleted', 0)
            ->get();
        return view('patient/nouveau-patient')->with($data);
    }


}
