@extends(session('layout') ?? 'layouts.app')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" href="{{ asset($v_cheque->dossier.'/devis/'.$v_cheque->id_devis.'/detail') }}" role="tab" aria-controls="overview" aria-selected="false">Devis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" href="{{ asset($v_cheque->dossier.'/prothese/'.$v_cheque->id_devis.'/detail') }}" role="tab" aria-selected="false">Prothèse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="contact-tab" data-bs-toggle="tab" href="#cheque" role="tab" aria-selected="true">Chèque</a>
            </li>
        </ul>
    </div>
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">Chèque dossier: {{ $v_cheque->dossier }}</h1>
            <div>
                <a href="{{ asset($v_cheque->dossier.'/cheque/'.$v_cheque->id_devis.'/modifier') }}">
                    <button class="btn btn-primary btn-lg text-white mb-0 me-0" type="button"><i class="mdi mdi-pen"></i>Modifier</button>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Info chèque</h4>
                    <p class="card-description">
                        <code>Nature: {{ $v_cheque->getNature_cheque() }}</code>
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <p class="fw-bold">N° {{ $v_cheque->getNumero_cheque() }}</p>
                                <p>
                                    <strong>Nom document:</strong> {{ $v_cheque->getNom_document() }}
                                </p>
                                <p>
                                    <strong>Travaux Sur le Devis:</strong> {{ $v_cheque->getTravaux_sur_devis() }}
                                </p>
                                <p>
                                    <strong>Situation:</strong> {{ $v_cheque->getSituation_cheque() }}
                                </p>
                            </address>
                        </div>
                        <div class="col-md-6">
                            <address class="text-primary">
                                <p class="fw-bold">Date d'encaissement</p>
                                <p class="mb-2">{{ $v_cheque->getDate_encaissement_cheque() }}</p>
                                <p class="fw-bold">Date de 1er L'acte</p>
                                <p>{{ $v_cheque->getDate_1er_acte() }}</p>
                            </address>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Montant: {{ $v_cheque->getMontant_cheque() }}</h4>
                    <p class="fw-bold">Observation:</p>
                    <p class="lead">{{ $v_cheque->getObservation() }}</p>
                </div>
            </div>
        </div>
    </div>

@endsection
