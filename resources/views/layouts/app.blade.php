
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hpi Suivis</title>
    <!-- plugins:css -->

    <link rel="stylesheet" href="{{ asset('star-admin2/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2/css/vertical-layout-light/style.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2-global/template.css') }}">
    <link rel="icon" href="{{ asset('HPI/logo(1).ico') }}" type="image/x-icon">
    <style>
        #deconnection{
            color: whitesmoke;
        }
        .sidebar{
            <!--
            background-image: linear-gradient(
                90deg,
                #0367A6 2%,
                #0367A6 7%,
                #F4F5F7 7%,
                #F4F5F7 8%,
                #F2AE2E 8%,
                #F2AE2E 12%,
                #F4F5F7 12%,
                #F4F5F7 73%,
                #F4F5F7 73%,
                #F4F5F7 74%,
                #F4F5F7 74%,
                #F4F5F7 78%,
                #F4F5F7 78%,
                #F4F5F7 100%
            );
            -->
        }
        .navbar .navbar-menu-wrapper{
            background-image: linear-gradient(
                -135deg,
                #575756 0%,
                #575756 15%,
                #F4F5F7 15%,
                #F4F5F7 44%,
                #F2AE2E 44%,
                #F2AE2E 73%,
                #F4F5F7 73%,
                #F4F5F7 74%,
                #0367A6 74%,
                #0367A6 78%,
                #F4F5F7 78%,
                #F4F5F7 100%
            );
        }
        .content-wrapper {
            background-image: linear-gradient(
                135deg,
                #F4F5F7 0%,
                #F4F5F7 70%,
                #F4F5F7 73%,
                #F4F5F7 74%,
                #0367A6 74%,
                #0367A6 81%
            );
            background-size: 100% auto;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }
        #search-results {
            width: 300px; /* Définir la largeur à 150px */
            max-height: 300px; /* Limite la hauteur */
            overflow-y: auto; /* Ajoute un défilement si nécessaire */
            background-color: #fff; /* Fond blanc */
            border: 1px solid #ddd; /* Bordure légère */
            border-radius: 8px; /* Coins arrondis */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombre subtile */
            margin-top: 5px; /* Espacement au-dessus */
            z-index: 1000; /* S'assurer qu'il est au-dessus des autres éléments */
            list-style: none; /* Supprime les puces */
            padding: 0; /* Supprime les marges/paddings internes */
        }


        #search-results .list-group-item {
            padding: 10px 15px; /* Ajoute un espacement */
            border-bottom: 1px solid #eee; /* Séparateurs entre les éléments */
            cursor: pointer; /* Curseur interactif */
            transition: background-color 0.2s, transform 0.1s; /* Animation fluide */
        }

        #search-results .list-group-item:last-child {
            border-bottom: none; /* Supprime la bordure du dernier élément */
        }

        #search-results .list-group-item:hover {
            background-color: #f8f9fa; /* Fond gris clair au survol */
            transform: scale(1.02); /* Légère mise en avant */
        }

        #search-results .list-group-item a {
            text-decoration: none; /* Supprime le soulignement des liens */
            color: #333; /* Couleur du texte */
            font-weight: 500; /* Texte légèrement en gras */
        }

        #search-results .list-group-item a:hover {
            color: #007bff; /* Couleur bleue au survol */
        }


    </style>
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
            <div class="me-3">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
            </div>
            <div>
                <a class="navbar-brand brand-logo" href="">
                    <img src="{{ asset('HPI/logo.jpg') }}" alt="logo" style="width: 100px; height: auto; object-fit: contain;" />
                </a>
                <a class="navbar-brand brand-logo-mini" href="index.html">
                    <img src="{{ asset('HPI/logo.jpg') }}" alt="logo" style="width: 75px; height: auto; object-fit: contain;" />
                </a>
            </div>

        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
            <ul class="navbar-nav">
                <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                    <h1 class="welcome-text"><span class="text-black fw-bold">{{ \Illuminate\Support\Facades\Auth::user()->nom }} </span></h1>
                    <h3 class="welcome-sub-text">{{ \Illuminate\Support\Facades\Auth::user()->role }} </h3>
                </li>
            </ul>

            <!-- Ajout du champ de recherche -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item position-relative">
                    <form class="d-flex">
                        <input
                            id="search-input"
                            class="form-control me-2"
                            type="search"
                            placeholder="Rechercher..."
                            aria-label="Search"
                            name="q">
                    </form>
                    <ul id="search-results" class="list-group position-absolute w-150" style="display: none; width: 300px">

                    </ul>
                </li>
            </ul>


            <script>
                document.getElementById('search-input').addEventListener('input', function () {
                    const query = this.value.trim();
                    const resultsContainer = document.getElementById('search-results');

                    if (query.length > 0) {
                        fetch(`/search?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                resultsContainer.innerHTML = ''; // Clear previous results
                                data.forEach(result => {
                                    const li = document.createElement('li');
                                    li.classList.add('list-group-item');
                                    li.innerHTML = `<a href="/${result.dossier}/details">${result.dossier}: ${result.nom} - ${result.date_naissance}</a>`;
                                    resultsContainer.appendChild(li);
                                });
                                resultsContainer.style.display = 'block';
                            })
                            .catch(error => console.error('Erreur:', error));
                    } else {
                        resultsContainer.style.display = 'none';
                    }
                });
            </script>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link btn btn-sm" id="deconnection" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout"></i> Déconnection
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>

            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>

    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->

        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#dashboard" aria-expanded="false" aria-controls="ui-basic">
                        <i class="menu-icon mdi mdi-view-dashboard"></i>
                        <span class="menu-title">Dashboard</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="dashboard">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ asset('dashboard/overview') }}">Overview</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ asset('dashboard/c-a') }}">CA</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ asset('dashboard/rappels') }}">Rappels</a></li>
                        </ul>
                    </div>
                </li>



                    <li class="nav-item nav-category">Information</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{asset('dossiers')}}">
                            <i class="mdi mdi-folder-open menu-icon"></i>
                            <span class="menu-title">Dossiers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{asset('liste/devis')}}">
                            <i class="mdi mdi-file-document-outline menu-icon"></i>
                            <span class="menu-title">DEVIS & <br>PROTHESE & CHQ</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('liste-ca') }}">
                            <i class="mdi mdi-cash-multiple menu-icon"></i>
                            <span class="menu-title">CA</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('ajouter-dossier') }}">
                            <i class="mdi mdi-account-plus menu-icon"></i>
                            <span class="menu-title">Nouveau patient</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#autre" aria-expanded="false" aria-controls="ui-basic">
                            <i class="menu-icon mdi mdi-dots-horizontal"></i>
                            <span class="menu-title">Autres</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="autre">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('liste-dossier-status') }}">Status dossier</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('liste-praticiens') }}">Praticiens</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('liste-pose-status') }}">Status pose</a></li>
                            </ul>
                        </div>
                    </li>
                <li class="nav-item nav-category">Gestion des utilisateurs</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ asset('utilisateurs') }}">
                        <i class="mdi mdi-account-multiple menu-icon"></i>
                        <span class="menu-title">Utilisateurs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#historiques" aria-expanded="false" aria-controls="ui-basic">
                        <i class="menu-icon mdi mdi-history"></i>
                        <span class="menu-title">Historiques</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="historiques">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ asset('historiques/modif-dev') }}">Devis</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ asset('historiques/modif-pro') }}">Prothèse</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ asset('historiques/modif-chq') }}">Chèques</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ asset('historiques/modif-ca') }}">CA</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ asset('') }}">Autres</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#erreurs" aria-expanded="false" aria-controls="ui-basic">
                        <i class="menu-icon mdi mdi-alert-circle"></i>
                        <span class="menu-title">Erreurs</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="erreurs">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ asset('erreur-import-1') }}">DEVIS & <br>PROTHESE & CHQ</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ asset('erreur-import-2') }}">CA</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="home-tab">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Hpi BUSINESS Partner</span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>

<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{ asset('star-admin2/js/jquery.cookie.js') }}" type="text/javascript"></script>
<script src="{{ asset('star-admin2-global/template.js') }}"></script>

<!-- End custom js for this page-->
</body>

</html>
