<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Dashboard;
use App\Models\views\stats\V_StatDevisEtat;
use App\Models\views\stats\V_StatDevisMens;
use App\Models\views\stats\V_StatNbrDevis;
use App\Models\views\V_Devis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function showDashboard(){
        $today = Carbon::today()->format('Y-m');
        $data['today'] = $today;
        // requetes: 2
        $data['v_stat_devis_mens'] = V_StatDevisMens::getV_StatDevisMensByDate($today);
        $data['v_stat_devis_etats'] = V_StatDevisEtat::where('annee_mois', $today)
            ->limit(11)
            ->get();
        return view('dashboard/dashboard')->with($data);
    }
    public function showDashboardRappels(){
        $m_dashboard = new Dashboard();
        $today = Carbon::today();
        $data['today'] = $today;
        $data['appoche_validite_pecs'] = V_Devis::where('date_fin_validite_pec', '>=', $today)
            ->orderBy('date_fin_validite_pec', 'asc')->get();
        $data['appels_mails_ajds'] = $m_dashboard->getAppelsAujourdHui();
        $data['reglements'] = V_Devis::where('date_paiement_cb_ou_esp', $today)
            ->orWhere('date_depot_chq_pec', $today)
            ->orWhere('date_depot_chq_part_mut', $today)
            ->orWhere('date_depot_chq_rac', $today)
            ->where('devis_signe', 'oui')
            ->get();

        return view('dashboard/dashboard-rappels')->with($data);
    }
}
