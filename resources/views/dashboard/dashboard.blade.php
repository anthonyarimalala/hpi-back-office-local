@extends(session('layout') ?? 'layouts.app')
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
                                <a class="nav-link" id="profile-tab" href="{{ asset('rappels/dashboard') }}" role="tab" aria-selected="false">Rappels</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content tab-content-basic">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="statistics-details d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="statistics-title">Mois</p>
                                            <h3 class="rate-percentage">{{ \Carbon\Carbon::parse($today)->format('F') }}</h3>
                                            <p class="text-black-50 d-flex align-items-center">
                                                <span class="ms-2">{{ \Carbon\Carbon::parse($today)->format('Y') }}</span>
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
                                                    {{ \Carbon\Carbon::parse($today)->format('F Y') }}
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
                                    <div class="col-md-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Headings with secondary text</h4>
                                                <p class="card-description">
                                                    Add faded secondary text to headings
                                                </p>
                                                <div class="template-demo">
                                                    <h1>
                                                        h1. Heading
                                                        <small class="text-muted">
                                                            Secondary text
                                                        </small>
                                                    </h1>
                                                    <h2>
                                                        h2. Heading
                                                        <small class="text-muted">
                                                            Secondary text
                                                        </small>
                                                    </h2>
                                                    <h3>
                                                        h3. Heading
                                                        <small class="text-muted">
                                                            Secondary text
                                                        </small>
                                                    </h3>
                                                    <h4>
                                                        h4. Heading
                                                        <small class="text-muted">
                                                            Secondary text
                                                        </small>
                                                    </h4>
                                                    <h5>
                                                        h5. Heading
                                                        <small class="text-muted">
                                                            Secondary text
                                                        </small>
                                                    </h5>
                                                    <h6>
                                                        h6. Heading
                                                        <small class="text-muted">
                                                            Secondary text
                                                        </small>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Display headings</h4>
                                                <p class="card-description">
                                                    Add class <code>.display1</code> to <code>.display-4</code>
                                                </p>
                                                <div class="template-demo">
                                                    <h1 class="display-1">Display 1</h1>
                                                    <h1 class="display-2">Display 2</h1>
                                                    <h1 class="display-3">Display 3</h1>
                                                    <h1 class="display-4">Display 4</h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-stretch">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Paragraph</h4>
                                                        <p class="card-description">
                                                            Write text in <code>&lt;p&gt;</code> tag
                                                        </p>
                                                        <p>
                                                            Lorem Ipsum is simply dummy text of the printing
                                                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                                            when an unknown printer took a galley not only five centuries,
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Icon size</h4>
                                                        <p class="card-description">
                                                            Add class <code>.icon-lg</code>, <code>.icon-md</code>, <code>.icon-sm</code>
                                                        </p>
                                                        <div class="row">
                                                            <div class="col-md-4 d-flex align-items-center">
                                                                <div class="d-flex flex-row align-items-center">
                                                                    <i class="ti-package icon-lg text-warning"></i>
                                                                    <p class="mb-0 ms-1">
                                                                        Icon-lg
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 d-flex align-items-center">
                                                                <div class="d-flex flex-row align-items-center">
                                                                    <i class="ti-package icon-md text-success"></i>
                                                                    <p class="mb-0 ms-1">
                                                                        Icon-md
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 d-flex align-items-center">
                                                                <div class="d-flex flex-row align-items-center">
                                                                    <i class="ti-package icon-sm text-danger"></i>
                                                                    <p class="mb-0 ms-1">
                                                                        Icon-sm
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Top aligned media</h4>
                                                <div class="media">
                                                    <i class="ti-world icon-md text-info d-flex align-self-start me-3"></i>
                                                    <div class="media-body">
                                                        <p class="card-text">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Center aligned media</h4>
                                                <div class="media">
                                                    <i class="ti-world icon-md text-info d-flex align-self-center me-3"></i>
                                                    <div class="media-body">
                                                        <p class="card-text">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Bottom aligned media</h4>
                                                <div class="media">
                                                    <i class="ti-world icon-md text-info d-flex align-self-end me-3"></i>
                                                    <div class="media-body">
                                                        <p class="card-text">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">


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
