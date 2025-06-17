@extends('layouts.app')
@section('content')
    <style>
        .chart-container {
            width: 100%;
            height: 300px; /* Ajuste cette valeur selon tes besoins */
            position: relative;
        }

    </style>
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" href="{{ asset('dashboard/overview') }}" role="tab" aria-controls="overview" aria-selected="false">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="profile-tab" href="" data-bs-toggle="tab" role="tab" aria-selected="true">CA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('dashboard/rappels') }}" role="tab" aria-selected="false">Rappels</a>
            </li>
        </ul>
        <div>
            <form action="#">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <input type="date" name="dashboard_ca_date_debut" value="{{ \Carbon\Carbon::parse($date_ca_debut)->format('Y-m-d') }}" class="form-control">
                    </li>
                    <li class="nav-item">
                        <input type="date" name="dashboard_ca_date_fin" value="{{ \Carbon\Carbon::parse($date_ca_fin)->format('Y-m-d') }}" class="form-control">
                    </li>
                    <li class="nav-item">
                        <button type="submit" class="btn btn-primary text-white me-0"><i class="icon-eye"></i> Aperçu</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
            <div class="row">
                <div class="col-lg-12 d-flex flex-column">
                    <div class="row flex-grow">
                        <div class="col-md-12 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h4 class="card-title card-title-dash">CA entre les dates: [{{ \Carbon\Carbon::parse($date_ca_debut)->format('d/m/Y') }} et {{ \Carbon\Carbon::parse($date_ca_fin)->format('d/m/Y') }}]</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th style="background-color: #4285f4; color: whitesmoke; text-align: right">Total</th>
                                                <th style="background-color: #4285f4; color: whitesmoke; text-align: right">Virement <br> en attente</th>
                                                <th style="background-color: #4285f4; color: whitesmoke; text-align: right">Indus payé</th>
                                                <th style="background-color: #4285f4; color: whitesmoke; text-align: right">Indus en attente</th>
                                                <th style="background-color: #4285f4; color: whitesmoke; text-align: right">Indus irrecouvrable</th>
                                                <th style="background-color: #4285f4; color: whitesmoke; text-align: right">Virement<br> reçu en compte</th>
                                            </tr>
                                            <tr>
                                                <th rowspan="4" style="writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; vertical-align: middle; background-color: #4285f4; color: whitesmoke">BILAN FINANCIER</th>
                                                <th style="background-color: #f9cb9c">Total Part Sécu</th>
                                                <td style="background-color: #f9cb9c; text-align: right">{{ number_format($bilan_financier->total_total_part_secu, 2, ',', ' ') }}</td>
                                                <td style="background-color: #f9cb9c; text-align: right">{{ number_format($bilan_financier->virement_en_attente_total_part_secu, 2, ',', ' ') }}</td>
                                                <td style="background-color: #f9cb9c; text-align: right">{{ number_format($bilan_financier->indus_paye_total_part_secu, 2, ',', ' ') }}</td>
                                                <td style="background-color: #f9cb9c; text-align: right">{{ number_format($bilan_financier->indus_en_attente_total_part_secu, 2, ',', ' ') }}</td>
                                                <td style="background-color: #f9cb9c; text-align: right">{{ number_format($bilan_financier->indus_irrecouvrable_total_part_secu, 2, ',', ' ') }}</td>
                                                <td style="background-color: #d9d9d9"></td>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #cfe2f3">Total Part Mut</th>
                                                <td style="background-color: #cfe2f3; text-align: right">{{ number_format($bilan_financier->total_total_part_mut, 2, ',', ' ') }}</td>
                                                <td style="background-color: #cfe2f3; text-align: right">{{ number_format($bilan_financier->virement_en_attente_total_part_mut, 2, ',', ' ') }}</td>
                                                <td colspan="3" style="background-color: #cfe2f3"></td>
                                                <td style="background-color: #d9d9d9"></td>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #d9d2e9">Total Part patient</th>
                                                <td style="background-color: #d9d2e9; text-align: right">{{ number_format($bilan_financier->total_total_part_patient, 2, ',', ' ') }}</td>
                                                <td style="background-color: #d9d2e9; text-align: right">{{ number_format($bilan_financier->virement_en_attente_total_part_patient, 2, ',', ' ') }}</td>
                                                <td colspan="3" style="background-color: #d9d2e9"></td>
                                                <td style="background-color: #d9d9d9; text-align: right"><strong>{{ number_format($bilan_financier->virement_recu_en_compte, 2, ',', ' ') }}</strong></td>
                                            </tr>
                                            <tr>
                                                <!-- L'intitulé du taux d'encaissement, qui s'étend sur trois colonnes -->
                                                <th colspan="3" style="font-size: 22px; font-weight: bold; background-color: #f3f3f3">
                                                    Taux d'encaissement
                                                </th>

                                                <!-- Affichage du taux d'encaissement formaté, qui occupe également trois colonnes et est centré -->
                                                <td colspan="3" style="text-align: center; font-size: 22px; font-weight: bold; background-color: #f3f3f3">
                                                    <strong>{{ number_format($bilan_financier->taux_encaissement, 2, ',', ' ') }} %</strong>
                                                </td>

                                            </tr>
                                            <tr>
                                                <th rowspan="2" style="writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; vertical-align: middle; background-color: #fbbc04; color: whitesmoke">CA</th>
                                                <th style="background-color: #fbbc04">CA Global</th>
                                                @foreach($ca_praticiens as $ca_p)
                                                    <th style="background-color: #fbbc04; color: whitesmoke; text-align: right"><strong>{{ $ca_p->praticien }}</strong></th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td style=""><strong>{{ number_format($bilan_financier->ca_global, 2, ',', ' ') }}</strong></td>
                                                @foreach($ca_praticiens as $ca_p)
                                                    <td style="text-align: right"><strong>{{ number_format($ca_p->sum_cotation_praticien, 2, ',', ' ') }}</strong></td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($ca_praticiens as $ca_p)
                    <div class="col-lg-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Praticien: {{ $ca_p->praticien }} ({{ $ca_p->sum_cotation_praticien }})</h4>
                                <div class="chart-container">
                                    <canvas id="myChart_{{ $ca_p->praticien }}" width="400" height="400"></canvas>
                                </div>
                                <div class="d-grid">
                                    <form class="form-group" action="{{ asset('getFilterCa') }}">
                                        <input name="date_ca_debut" value="{{ \Carbon\Carbon::parse($date_ca_debut)->format('d/m/Y') }}" hidden>
                                        <input name="date_ca_fin" value="{{ \Carbon\Carbon::parse($date_ca_fin)->format('d/m/Y') }}" hidden>
                                        <input name="praticiens[]" value="{{ $ca_p->praticien }}" hidden>
                                        <input name="non_regle_cotation[]" value="non_reglee" hidden>
                                        <button class="btn btn-primary" style="color: whitesmoke">Consulter les restes à payer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        // Calculer les valeurs pour le graphique
                        $total_cotation = $ca_p->sum_cotation_praticien;
                        $reste_a_paye = $ca_p->sum_cotation_praticien_reste_a_paye;
                        $paye = $total_cotation - $reste_a_paye;
                        $pourcentage_paye = ($total_cotation > 0) ? ($paye / $total_cotation) * 100 : 0;
                    @endphp

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var ctx = document.getElementById("myChart_{{ $ca_p->praticien }}").getContext("2d");
                            new Chart(ctx, {
                                type: "doughnut",
                                data: {
                                    labels: ["Reste à payer", "Payé"],
                                    datasets: [{
                                        data: [{{ $paye }}, {{ $reste_a_paye }}],
                                        backgroundColor: ["#FF5733", "#4CAF50"]
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false
                                }
                            });
                        });

                    </script>
                @endforeach

            </div>
        </div>
    </div>
    <script src="{{ asset('chart.js/Chart.min.js') }}"></script>

    {{--
        @php
        foreach ($ca_praticiens as $ca_p){
            echo 'cotation praticien '.$ca_p->praticien. ': '.$ca_p->sum_cotation_praticien.'</br>';
            echo 'cotation payé '.$ca_p->praticien. ': '.$ca_p->sum_cotation_praticien_reste_a_paye.'<br>';
        }
        @endphp
    --}}






    @endsection
