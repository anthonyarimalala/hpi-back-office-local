
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
                <a class="navbar-brand brand-logo" href="index.html">
                    <img src="{{ asset('HPI/logo.jpg') }}" alt="logo" />
                </a>
                <a class="navbar-brand brand-logo-mini" href="index.html">
                    <img src="{{ asset('star-admin2/images/logo-mini.svg') }}" alt="logo" />
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
                <li class="nav-item">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Rechercher..." aria-label="Search" name="q">
                    </form>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link btn btn-sm" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout"></i> Déconnexion
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


                @if(\Illuminate\Support\Facades\Auth::user()->role == 'cuisinier' )

                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{asset('/')}}">
                        <i class="mdi mdi-view-dashboard menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>



                    <li class="nav-item nav-category">Information</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{asset('dossiers')}}">
                            <i class="mdi mdi-folder-open menu-icon"></i>
                            <span class="menu-title">Dossiers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{asset('liste-devis')}}">
                            <i class="mdi mdi-file-document-outline menu-icon"></i>
                            <span class="menu-title">Devis</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('ajouter-patient') }}">
                            <i class="mdi mdi-folder-plus menu-icon"></i>
                            <span class="menu-title">Nouveau patient</span>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#entree" aria-expanded="false" aria-controls="ui-basic">
                            <i class="menu-icon mdi mdi-cart-arrow-down"></i>
                            <span class="menu-title">Entrée</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="entree">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('entree-produit') }}">Produit à vendre</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('entree-ingredient') }}">Ingrédient</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('entree-non-consommable') }}">Non Consommable</a></li>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const layoutKey = 'app_layout';
        let currentLayout = localStorage.getItem(layoutKey);

        if (!currentLayout) {
            currentLayout = 'layouts.app';
            localStorage.setItem(layoutKey, currentLayout);
        }

        fetch('/set-layout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ layout: currentLayout })
        }).then(response => {
            if (response.ok) {
                console.log('Layout configuré pour cette session.');
            }
        });
    });
</script>


<!-- End custom js for this page-->
</body>

</html>
