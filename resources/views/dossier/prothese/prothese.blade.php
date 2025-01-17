@extends(session('layout') ?? 'layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" href="{{ asset($v_prothese->dossier.'/devis/'.$v_prothese->id_devis.'/detail') }}" role="tab" aria-controls="overview" aria-selected="false">Devis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#prothese" role="tab" aria-selected="true">Prothèse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" href="{{ asset($v_prothese->dossier.'/cheque/'.$v_prothese->id_devis.'/detail') }}" role="tab" aria-selected="false">Chèque</a>
            </li>
        </ul>
    </div>
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">Prothèse dossier: {{ $v_prothese->dossier }}</h1>
            <div>
                <a href="{{ asset($v_prothese->dossier.'/prothese/'.$v_prothese->id_devis.'/modifier') }}">
                    <button class="btn btn-primary btn-lg text-white mb-0 me-0" type="button"><i class="mdi mdi-pen"></i>Modifier</button>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Empreintes</h4>
                    <div class="table-responsive mt-1"> <!-- Conteneur pour la responsivité -->
                        <table class="table table-bordered">
                            <thead class="table-light">
                            <tr>
                                <th>Laboratoire</th>
                                <th>Date Empreinte</th>
                                <th>Date Envoi Labo</th>
                                <th>Travail Demandé</th>
                                <th>Numéro Dent</th>
                                <th>Observations</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ $v_prothese->getLaboratoire() }}</td>
                                <td>{{ $v_prothese->getDate_empreinte() }}</td>
                                <td>{{ $v_prothese->getDate_envoi_labo() }}</td>
                                <td>{{ $v_prothese->getTravail_demande() }}</td>
                                <td>{{ $v_prothese->getNumero_dent() }}</td>
                                <td>{{ $v_prothese->getObservations() }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Retour Labo</h4>
                    <div class="table-responsive"> <!-- Conteneur pour la responsivité -->
                        <table class="table table-bordered">
                            <thead class="table-light">
                            <tr>
                                <th>Date Livraison</th>
                                <th>Numéro Suivi</th>
                                <th>Numéro Facture Labo</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ $v_prothese->getDate_livraison() }}</td>
                                <td>{{ $v_prothese->getNumero_suivi() }}</td>
                                <td>{{ $v_prothese->getNumero_facture_labo() }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Travaux</h4>
                    <div class="table-responsive"> <!-- Conteneur pour la responsivité -->
                        <table class="table table-bordered">
                            <thead class="table-light">
                            <tr>
                                <th>Date Pose Prévue</th>
                                <th>Statut</th>
                                <th>Date Pose Réel</th>
                                <th>Organisme Payeur</th>
                                <th>Montant Encaissé</th>
                                <th>Date Contrôle Paiement</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ $v_prothese->getDate_pose_prevue() }}</td>
                                <td>{{ $v_prothese->getStatut() }}</td>
                                <td>{{ $v_prothese->getDate_pose_reel() }}</td>
                                <td>{{ $v_prothese->getOrganisme_payeur() }}</td>
                                <td>{{ $v_prothese->getMontant_encaisse() }}</td>
                                <td>{{ $v_prothese->getDate_controle_paiement() }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
