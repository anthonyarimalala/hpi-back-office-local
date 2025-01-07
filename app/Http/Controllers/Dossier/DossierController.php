<?php

namespace App\Http\Controllers\Dossier;

use App\Http\Controllers\Controller;
use App\Models\devis\Devis;
use App\Models\dossier\Dossier;
use App\Models\dossier\DossierStatus;
use App\Models\dossier\L_DossierMutuelle;
use App\Models\views\V_Devis;
use App\Models\views\V_Dossier;
use Illuminate\Http\Request;

class DossierController extends Controller
{
    //

    public function showDetailDossier($dossier){
        $data['v_devis'] = V_Devis::where('dossier',$dossier)->first();
        return view('dossier/details/detail-dossier-devis')->with($data);
    }
    public function supprimerMutuelle($dossier, $mutuelle)
    {
        $dossier_mutuelle = L_DossierMutuelle::where('dossier', $dossier)
            ->where('mutuelle', $mutuelle)
            ->first();
        $dossier_mutuelle->is_deleted = 1;
        $dossier_mutuelle->save();
        return back();
    }
    public function modifierDossier(Request $request)
    {
        $i_dossier = $request->input('dossier');
        $i_status = $request->input('status');
        $i_mutuelles = $request->input('mutuelle', []);

        Dossier::modifierDossier($i_dossier, $i_status);
        foreach ($i_mutuelles as $i_mutuelle){
            L_DossierMutuelle::insertL_DossierMutuelle($i_dossier, $i_mutuelle);
        }
        return back()->with('success', 'Le dossier "'.$i_dossier.'" a été mis à jour.');
    }
    public function showModifierDossier($dossier)
    {
        $data['statuss'] = DossierStatus::orderBy('ordre', 'desc')
            ->where('is_deleted', 0)
            ->orderBy('status', 'asc')
            ->get();
        $data['v_dossier'] = V_Dossier::where('dossier', $dossier)
            ->where('is_deleted', 0)
            ->first();
        $data['dossier_muts'] = L_DossierMutuelle::where('dossier', $dossier)
            ->where('is_deleted', 0)
            ->get();

        // print($data['v_dossier']);
        return view('dossier/modifier-dossier')->with($data);
    }
    public function insertDossier(Request $request){
        $validated = $request->validate([
           'numero' => 'required|min:3',
           'id_patient' => 'required',
           'status' => 'required',
        ]);
        $numero = $request->input('numero');
        $id_patient =$request->input('id_patient');
        $status = $request->input('status');
        Dossier::insertDossier($numero, $id_patient, $status);
        return back()->with('success', 'Le dossier "'.$numero.'" a été ajouté avec success!');
    }
    public function showDossiers()
    {
        $data['v_dossiers'] = V_Dossier::all();
        return view('dossier/liste-dossier')->with($data);
    }
}
