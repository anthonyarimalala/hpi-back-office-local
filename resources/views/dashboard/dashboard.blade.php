@extends('layouts.app')
@section('content')


        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" href="{{ asset('dashboard/ca') }}" role="tab" aria-selected="false">CA</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" href="{{ asset('dashboard/rappels') }}" role="tab" aria-selected="false">Rappels</a>
                            </li>
                        </ul>

                        <div>
                            <form action="#">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <input type="date" name="dashboard_date_debut" value="{{ \Carbon\Carbon::parse($date_debut)->format('Y-m-d') }}" class="form-control">
                                    </li>
                                    <li class="nav-item">
                                        <input type="date" name="dashboard_date_fin" value="{{ \Carbon\Carbon::parse($date_fin)->format('Y-m-d') }}" class="form-control">
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
                                <div class="col-sm-4">
                                    <div class="statistics-details d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="statistics-title">Date</p>
                                            <h3 class="rate-percentage">{{ \Carbon\Carbon::parse($date_fin)->format('d-m-Y') }}</h3>
                                            <p class="text-black-50 d-flex align-items-center">
                                                <span class="ms-2">{{ \Carbon\Carbon::parse($date_debut)->format('d-m-Y') }}</span>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="statistics-title">Nbr de devis</p>
                                            <h3 class="rate-percentage">{{ $v_stat_devis_mens->nbr_devis }}</h3>
                                            <p class="d-flex align-items-center">
                                                <span class="ms-2 text-success">
                                                    signés: {{ $v_stat_devis_mens->nbr_devis_signe }}
                                                </span>,
                                                <span class="ms-2 text-danger">
                                                     non-signés: {{ $v_stat_devis_mens->nbr_devis_non_signe }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Etats de devis</h4>
                                                <p class="card-description">
                                                    {{ \Carbon\Carbon::parse($date_debut)->format('d-m-Y') }} -> {{ \Carbon\Carbon::parse($date_fin)->format('d-m-Y') }}
                                                </p>
                                                <div style="display: flex; align-items: center; gap: 20px; width: 100%;">
                                                    <!-- Conteneur du Canvas -->
                                                    <div style="width: 300px; height: 300px; position: relative;">
                                                        <canvas
                                                            style="width: 100%; height: 100%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"
                                                            id="myPieChart"></canvas>
                                                    </div>
                                                    <!-- Conteneur des écritures -->
                                                    <div style="flex: 1;">
                                                        <ul id="chartLegend" style="list-style: none; padding: 0; margin: 0; font-family: Arial, sans-serif;">
                                                            <!-- Les légendes des états seront insérées ici dynamiquement -->
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('chart.js/Chart.min.js') }}"></script>
        <script>
            // Récupère les données envoyées depuis le backend et les convertit en objet JSON
            var v_stat_devis_etats = @json($v_stat_devis_etats);

            // Prépare les données pour le graphique
            var labels = [];
            var data = [];
            var colors = [];

            v_stat_devis_etats.forEach(function(item) {
                //labels.push(item.etat);               // Ajoute l'état au tableau des labels
                data.push(item.nbr_devis);            // Ajoute le nombre de devis au tableau des données
                colors.push(item.couleur);            // Ajoute la couleur associée à chaque état
            });

            // Récupère le contexte du canvas pour dessiner le graphique
            var ctx = document.getElementById('myPieChart').getContext('2d');

            // Crée le graphique circulaire
            var myPieChart = new Chart(ctx, {
                type: 'pie', // Type du graphique : Circulaire
                data: {
                    labels: labels, // Labels : états des devis
                    datasets: [{
                        data: data, // Données : nombre de devis par état
                        backgroundColor: colors, // Couleurs associées à chaque état
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // On désactive la légende intégrée de Chart.js
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    // Affiche le nombre de devis et l'état dans l'info-bulle
                                    return tooltipItem.label + ': ' + tooltipItem.raw + ' devis';
                                }
                            }
                        }
                    }
                }
            });

            // Génère les légendes à droite
            var legendContainer = document.getElementById('chartLegend');
            v_stat_devis_etats.forEach(function(item, index) {
                var legendItem = document.createElement('li');
                legendItem.style.display = 'flex';
                legendItem.style.alignItems = 'center';
                legendItem.style.marginBottom = '8px';

                var colorBox = document.createElement('span');
                colorBox.style.width = '20px';
                colorBox.style.height = '20px';
                colorBox.style.backgroundColor = colors[index];
                colorBox.style.marginRight = '10px';
                colorBox.style.borderRadius = '50%';

                var labelText = document.createElement('span');
                labelText.textContent = `${item.nbr_devis} - ${item.etat} `;

                legendItem.appendChild(colorBox);
                legendItem.appendChild(labelText);
                legendContainer.appendChild(legendItem);
            });
        </script>

@endsection
