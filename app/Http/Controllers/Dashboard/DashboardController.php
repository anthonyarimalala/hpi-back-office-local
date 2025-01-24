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
    public function showDashboard(){
        $m_dashboard = new Dashboard();
        $details_dossier = $m_dashboard->getDetailsDossier();
        $details_devis = $m_dashboard->getDetailsDevis();
        $data['details_dossier'] = $details_dossier[0];
        $data['details_devis'] = $details_devis[0];
        return view('dashboard/dashboard')->with($data);
    }
    public function showDashboardRappels(){
        $m_dashboard = new Dashboard();
        $today = Carbon::today();
        $data['appoche_validite_pecs'] = V_Devis::where('date_fin_validite_pec', '>=', $today)
            ->orderBy('date_fin_validite_pec', 'asc')->get();
        $data['appels_mails_ajds'] = $m_dashboard->getAppelsAujourdHui();
        return view('dashboard/dashboard-rappels')->with($data);
    }
}
