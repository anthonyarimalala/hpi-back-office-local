@extends('layouts.app')
@section('content')
    <style>
        .card-header {
            background: linear-gradient(
                -135deg,
                transparent 60%,
                #575756 60%,
                #575756 100%);
        }
    </style>
    @php
        $couleur_reste_a_payer = '';
        if($v_prothese->reste_a_payer > 0){
            $couleur_reste_a_payer = 'red';
        }else if($v_prothese->reste_a_payer < 0){
            $couleur_reste_a_payer = 'red';
        }else if($v_prothese->reste_a_payer == 0){
            $couleur_reste_a_payer = 'green';
        }
        if($v_prothese->montant_acte == 0 || $v_prothese->montant_acte == null || $v_prothese->montant_acte == ''){
            $couleur_reste_a_payer = 'red';
        }
    @endphp
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" href="{{ asset($v_prothese->dossier.'/devis/'.$v_prothese->id_devis.'/acte'.$id_acte.'/detail') }}" role="tab" aria-controls="overview" aria-selected="false">Devis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#prothese" role="tab" aria-selected="true">Prothèse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" href="{{ asset($v_prothese->dossier.'/cheque/'.$v_prothese->id_devis.'/acte'.$id_acte.'/detail') }}" role="tab" aria-selected="false">Chèque</a>
            </li>
        </ul>
    </div>
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">Prothèse dossier: {{ $v_prothese->dossier }}</h1>
            <div>
                {{-- <a href="{{ asset($v_prothese->dossier.'/prothese/'.$v_prothese->id_devis.'/acte'.$id_acte.'/modifier') }}"> --}}
                    <button class="btn btn-primary btn-lg text-white mb-0 me-0" onclick="window.location.href='{{ asset($v_prothese->dossier.'/prothese/'.$v_prothese->id_devis.'/acte'.$id_acte.'/modifier') }}'" type="button"><i class="mdi mdi-pen"></i>Modifier</button>
                {{-- </a> --}}

                {{-- <a href="{{ asset('getCA/'.$id_acte.'/') }}"> --}}
                    @if(\Illuminate\Support\Facades\Auth::user()->role != 'user')
                        <button class="btn btn-info btn-lg text-white mb-0 me-0" onclick="window.location.href='{{ asset('getCaFromProthese/'.$id_acte.'/') }}'" type="button"><i class="mdi mdi-eye"></i>CA</button>
                    @endif
                {{-- </a> --}}
            </div>
            @if ($errors->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header text-white">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title mb-0" style="color: whitesmoke">Empreintes</h4>
                        </div>
                        <div>
                            <a href="{{ asset($v_prothese->dossier.'/prothese/'.$v_prothese->id_devis.'/acte'.$id_acte.'/nouveau-acte') }}" class="text-primary">
                                <i class="mdi mdi-plus mdi-24px">Ajouter un acte(travail demandé)</i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-1"> <!-- Conteneur pour la responsivité -->
                        <table class="table table-bordered">
                            <thead class="table-light">
                            <tr>
                                <th>Laboratoire</th>
                                <th>Date Empreinte</th>
                                <th>Date Envoi Labo</th>
                                <th>Travail Demandé</th>
                                <th>Montant</th>
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
                                <td style="background-color: {{ $couleur_reste_a_payer }}">{{ $v_prothese->getMontantActe() }}</td>
                                <td>{{ $v_prothese->getNumero_dent() }}</td>
                                <td style="white-space: pre-line; word-break: break-word; max-width:300px;">{{ $v_prothese->getObservations() }}</td>
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
                <div class="card-header text-white">
                    <h4 class="card-title mb-0" style="color: whitesmoke">Retour Labo</h4>
                </div>
                <div class="card-body">
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
                <div class="card-header text-white">
                    <h4 class="card-title mb-0" style="color: whitesmoke">Travaux</h4>
                </div>
                <div class="card-body">
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

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-white" style="background: #F2CED5;">
                    <h4 class="card-title mb-0">Historique</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Dossier</th>
                            <th>Action</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($hists as $hist)
                            <tr>
                                <td>{{ $hist->nom }}</td>
                                <td>{{ $hist->dossier }}</td>
                                <td>{!! nl2br($hist->action) !!}</td>
                                <td>{{ \Carbon\Carbon::parse($hist->created_at)->format('d-m-Y H:m') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
