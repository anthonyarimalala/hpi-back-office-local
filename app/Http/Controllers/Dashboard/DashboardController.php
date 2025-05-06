<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Dashboard;
use App\Models\views\V_Devis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function showDashboardCa(Request $request){
        $m_dash = new Dashboard();
        $date_ca_debut = $request->input('dashboard_ca_date_debut');
        $date_ca_fin = $request->input('dashboard_ca_date_fin');

        if (!$date_ca_debut || $date_ca_debut == '') $date_ca_debut = Carbon::now()->startOfMonth()->toDateString();
        if (!$date_ca_fin || $date_ca_fin=='') $date_ca_fin = Carbon::today()->format('Y-m-d');

        $data['date_ca_debut'] = $date_ca_debut;
        $data['date_ca_fin'] = $date_ca_fin;
        $data['bilan_financier'] = $m_dash->getCaBilanFincancier($date_ca_debut, $date_ca_fin);
        $data['ca_praticiens'] = $m_dash->getCaPraticiens($date_ca_debut, $date_ca_fin);
        return view('dashboard/dashboard-ca')->with($data);
    }
    public function showDashboard(Request $request){
        $m_dash = new Dashboard();
        $date_debut = $request->input('dashboard_date_debut');
        $date_fin = $request->input('dashboard_date_fin');

        if (!$date_debut || $date_debut == '') $date_debut = Carbon::now()->startOfMonth()->toDateString();
        if (!$date_fin || $date_fin=='') $date_fin = Carbon::today()->format('Y-m-d');

        $data['date_debut'] = $date_debut;
        $data['date_fin'] = $date_fin;
        $data['v_stat_devis_mens'] = $m_dash->getTotalDevisSigne($date_debut, $date_fin);
        $data['v_stat_devis_etats'] = $m_dash->getTotalDevisEtats($date_debut, $date_fin);
        $data['v_stat_pose_status'] = $m_dash->getTotalPoseStatus($date_debut, $date_fin);
        return view('dashboard/dashboard')->with($data);
    }
    public function showDashboardRappels(){
        $m_dashboard = new Dashboard();
        $today = Carbon::today();
        $data['today'] = $today;

        // $data['appoche_validite_pecs'] = V_Devis::where('date_fin_validite_pec', '>=', $today)
        //     ->orderBy('date_fin_validite_pec', 'asc')->get();

        // $data['reglements'] = V_Devis::where('date_paiement_cb_ou_esp', $today)
        //     ->orWhere('date_depot_chq_pec', $today)
        //     ->orWhere('date_depot_chq_part_mut', $today)
        //     ->orWhere('date_depot_chq_rac', $today)
        //     ->get();
        $data['validite_pecs'] = $m_dashboard->getFinValiditePecs();
        $data['appels_mails_ajdss'] = $m_dashboard->getAppelsMailsAujourdHui();
        $data['m_dash'] = $m_dashboard;
        return view('dashboard/dashboard-rappels')->with($data);
    }



}
