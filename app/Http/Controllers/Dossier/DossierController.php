<?php

namespace App\Http\Controllers\Dossier;

use App\Http\Controllers\Controller;
use App\Models\devis\Devis;
use App\Models\dossier\Dossier;
use App\Models\dossier\DossierStatus;
use App\Models\views\V_CaActesReglement;
use App\Models\views\V_Devis;
use Illuminate\Http\Request;

class DossierController extends Controller
{
    //
    public function getDetailDossier($dossier)
    {
        $data['deviss'] = V_Devis::where('dossier', $dossier)->orderBy('date', 'desc')->get();
        $data['dossier'] = Dossier::where('dossier', $dossier)->first();
        $data['ca_actes_reglements'] = V_CaActesReglement::where('dossier', $dossier)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('dossier/details/detail-dossier')->with($data);
    }
    public function modifierDossier(Request $request)
    {
        $i_dossier = $request->input('dossier');
        $i_nom = $request->input('nom');
        $i_status = $request->input('status');
        $mutuelle = $request->input('mutuelle');

        Dossier::modifierDossier($i_dossier, $i_nom, $i_status, $mutuelle);
        return redirect('dossiers');
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
        $data['v_dossiers'] = Dossier::orderBy('dossier')->paginate(15);
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
            ->where('status', '!=', '')
            ->where('is_deleted', 0)
            ->get();
        return view('dossier/nouveau-dossier')->with($data);
    }
}
