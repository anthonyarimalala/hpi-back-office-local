<?php

namespace App\Http\Controllers\Dossier\Devis;

use App\Http\Controllers\Controller;
use App\Models\devis\Devis;
use App\Models\praticien\Praticien;
use App\Models\views\V_Devis;
use App\Models\views\V_PatientDossier;
use Illuminate\Http\Request;

class DevisController extends Controller
{
    //
    public function modifierDevis(Request $request)
    {
        try {
            $dossier = $request->input('dossier');
            $date = $request->input('date');
            $montant = $request->input('montant');
            $devis_signe = $request->input('devis_signe');
            $praticien = $request->input('praticien');
            $observation = $request->input('observation');

            Devis::createDevis($dossier, $date, $montant, $devis_signe, $praticien, $observation);

            return back()->with('success', 'Le devis a été modifié avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la modification du devis : ' . $e->getMessage());
        }
    }

    public function showModifierDevis($dossier){
        $data['v_devis'] = V_Devis::where('dossier',$dossier)->first();
        return view('dossier/details/modifier/detail-dossier-devis-modifier')->with($data);
    }

    /*
        try {
            $dossier = $request->input('dossier');
            $date = $request->input('date');
            $montant = $request->input('montant');
            $devis_signe = $request->input('devis_signe');
            $praticien = $request->input('praticien');
            $observation = $request->input('observation');
            Devis::createDevis($dossier, $date, $montant, $devis_signe, $praticien, $observation);
            return redirect()->route('liste-devis', ['dossier' => $dossier])->with('success', 'Le devis a été modifié avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la modification du devis : ' . $e->getMessage());
        }*/
    public function getDevis($dossier, $id_devis){
        $data['v_devis'] = V_Devis::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        return view('dossier/devis/detail/devis-prothese-chq')->with($data);
    }
    public function creerDevis(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'date' => 'required|date',
            'montant' => 'required|numeric|min:0.01',
            'devis_signe' => 'required|in:oui,non',
            'praticien' => 'required|exists:praticiens,praticien',  // Assurez-vous que la table 'praticiens' et la colonne 'praticien' existent
            'observation' => 'nullable|string|max:500',  // 'nullable' permet de laisser ce champ vide
        ]);

        // Récupération des données validées
        $dossier = $request->input('dossier');
        $date = $validated['date'];
        $montant = $validated['montant'];
        $devis_signe = $validated['devis_signe'];
        $praticien = $validated['praticien'];
        $observation = $validated['observation'];

        try {
            // Création du devis
            Devis::createDevis($dossier, $date, $montant, $devis_signe, $praticien, $observation);
            return redirect()->to($dossier.'/liste-devis')->with('success', 'Le devis a été ajouté avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la modification du devis : ' . $e->getMessage());
        }
    }

    public function nouveauDevis($dossier){
        $data['dossier'] = V_PatientDossier::where('dossier', $dossier)->first();
        $data['praticiens'] = Praticien::where('is_deleted', 0)->get();
        return view('dossier/devis/nouveau-devis')->with($data);
    }
    public function getListeDevis($dossier){
        $data['deviss'] = Devis::where('dossier', $dossier)->orderBy('date', 'desc')->get();
        $data['dossier'] = V_PatientDossier::where('dossier', $dossier)->first();
        return view('dossier/devis/liste-devis-dossier')->with($data);
    }
}
