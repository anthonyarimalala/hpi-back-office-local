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
        $mutuelle = $request->input('mutuelle');

        Dossier::modifierDossier($i_dossier, $i_status, $mutuelle);
        return back()->with('success', 'Le dossier "'.$i_dossier.'" a été mis à jour.');
    }
    public function showModifierDossier($dossier)
    {
        $data['statuss'] = DossierStatus::orderBy('ordre', 'desc')
            ->where('is_deleted', 0)
            ->orderBy('status', 'asc')
            ->get();
        $data['v_dossier'] = Dossier::where('dossier', $dossier)
            ->where('is_deleted', 0)
            ->first();

        // print($data['v_dossier']);
        return view('dossier/modifier-dossier')->with($data);
    }
    public function showDossiers()
    {
        $data['v_dossiers'] = Dossier::all();
        return view('dossier/liste-dossier')->with($data);
    }

    public function insertDossier(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|min:3',
            'date_naissance' => 'required',
        ]);
        $nom = $request->input('nom');
        $date_naissance = $request->input('date_naissance');
        $dossier = $request->input('dossier');
        $status = $request->input('status');
        $mutuelle = $request->input('mutuelle');

        Dossier::insertDossier($dossier, $nom, $date_naissance, $status, $mutuelle); // insérer son dossier


        return redirect()->route('dossiers')->with('success', 'Le patient "'.$nom.'" a été ajouté avec success');
    }
    public function showInsertDossier(Request $request){
        $data['statuss'] = DossierStatus::orderBy('ordre', 'desc')
            ->orderBy('status', 'asc')
            ->where('is_deleted', 0)
            ->get();
        return view('dossier/nouveau-dossier')->with($data);
    }
}
