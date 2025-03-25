<?php

namespace App\Http\Controllers\ca;

use App\Http\Controllers\Controller;
use App\Models\ca\CaActesReglement;
use App\Models\ca\CaGeneral;
use App\Models\ca\L_CaActesReglement;
use App\Models\dossier\DossierStatus;
use App\Models\hist\H_CaActesReglement;
use App\Models\praticien\Praticien;
use App\Models\views\V_CaActesReglement;
use Illuminate\Http\Request;

class Ca2Controller extends Controller
{

    // debut: insertion d'un acte de CA s'il y'en a déjà
    public function insertNouveauCaActe(Request $request, $id_ca){
        $m_l_ca_actes_reglement = L_CaActesReglement::insertCaActesReglement($request, $id_ca);
        return redirect('liste-ca');
    }
    public function showNouveauCaActe($id_ca){
        $data['m_ca'] = V_CaActesReglement::where('id', $id_ca)->first();
        $data['m_praticiens'] = Praticien::where('praticien', '!=', '')->where('is_deleted', 0)->get();
        return view('ca/nouveau/actes/nouveau-ca-acte')->with($data);
    }
    // fin: insertion d'un acte de CA s'il y'en a déjà
    public function showUpdateCa($id_ca_actes_reglement, $dossier){
        $data['v_ca_actes_reglement'] = V_CaActesReglement::where('id_ca_actes_reglement', $id_ca_actes_reglement)->where('dossier', $dossier)->first();
        if(!$data['v_ca_actes_reglement']){
            return back();
        }
        $data['status'] = DossierStatus::where('is_deleted', 0)->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)
            ->where('praticien', '!=', '')->get();

        $data['hists'] = H_CaActesReglement::orderBy('created_at', 'desc')
            ->where('id_ca_actes_reglement', $id_ca_actes_reglement)
            ->paginate(15);
        if(!$data['v_ca_actes_reglement']) return back();
        return view('ca/modifier/modifier-ca')->with($data);
    }
    public function updateCa(Request $request, $id_ca_actes_reglement){
        $m_l_ca_actes_reglement = L_CaActesReglement::updateCaActesReglement($request, $id_ca_actes_reglement);
        return redirect('liste-ca');
    }
    //Insertion du CA s'il n'y a pas encore d'acte
    public function insertCa(Request $request){
        $m_ca = CaGeneral::createCa($request);
        $m_l_ca_actes_reglement = L_CaActesReglement::insertCaActesReglement($request, $m_ca->id);
        return redirect('liste-ca');
    }
}
