@extends('layouts.app')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#devis" role="tab" aria-controls="overview" aria-selected="true">Devis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" href="{{ asset($v_devis->dossier.'/prothese/'.$v_devis->id_devis.'/detail') }}" role="tab" aria-selected="false">Prothèse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" href="{{ asset($v_devis->dossier.'/cheque/'.$v_devis->id_devis.'/detail') }}" role="tab" aria-selected="false">Chèque</a>
            </li>
        </ul>
    </div>
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <h1 class="display-4 me-3">Devis dossier: {{ $v_devis->dossier }}</h1>
            <a href="{{ asset($v_devis->dossier.'/devis/'.$v_devis->id_devis.'/modifier') }}">
                <button class="btn btn-primary btn-lg text-white" type="button"><i class="mdi mdi-pen"></i>Modifier</button>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Info Devis Section -->
        <div class="col-md-12 grid-margin">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title text-primary">Info Deviss</h4>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            @if($v_devis->etat != '' && $v_devis->etat != null)
                                <h3 class="p-3 text-white rounded" style="background-color: {{ $v_devis->couleur }};">{{ $v_devis->etat }}</h3>
                            @endif
                            <p class="text-muted">Dossier: <span class="fw-bold">{{ $v_devis->dossier }}</span></p>
                            <p class="text-muted">Nom: <span class="fw-bold">{{ $v_devis->nom }}</span></p>
                            <p class="text-muted">Status: <span class="fw-bold">{{ $v_devis->status }}</span></p>
                            <p class="text-muted">Mutuelle: <span class="fw-bold">{{ $mutuelles->pluck('mutuelle')->join(' ') }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted">Date: <span class="fw-bold">@if($v_devis->date != null) {{ \Carbon\Carbon::parse($v_devis->date)->translatedFormat('d F Y') }} @endif</span></p>
                            <p class="text-muted">Montant: <span class="fw-bold">{{ number_format($v_devis->montant, 2, ',', ' ') }} Euro</span></p>
                            @if($v_devis->devis_signe == 'oui')
                                <p class="badge bg-success text-light">Signé</p>
                            @else
                                <p class="badge bg-danger text-light">Non Signé</p>
                            @endif
                            <p class="text-muted">Praticien: <span class="fw-bold">{{ $v_devis->getPraticien() }}</span></p>
                            <p class="text-muted">Observation: <span class="fw-bold">{{ $v_devis->getObservation() }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Retour Mutuelle Section -->
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title text-primary">Retour Mutuelle</h4>
                    <div class="list-group">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Envoi PEC</span>
                            <span class="text-muted small">{{ $v_devis->getDate_paiement_cb_ou_esp() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Fin validité PEC</span>
                            <span class="text-muted small">{{ $v_devis->getDate_depot_chq_pec() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Part Mutuelle</span>
                            <span class="text-muted small">{{ $v_devis->getDate_depot_chq_part_mut() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Part RAC</span>
                            <span class="text-muted small">{{ $v_devis->getDate_depot_chq_rac() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Règlements Section -->
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title text-primary">Règlements</h4>
                    <div class="list-group">
                        <div class="list-group-item">
                            <span class="d-block text-muted">Date paiement par CB ou Esp</span>
                            <i class="mdi mdi-calendar text-muted"></i> {{ $v_devis->getDate_paiement_cb_ou_esp() }}
                        </div>
                        <div class="list-group-item">
                            <span class="d-block text-muted">Date dépôt CHQ PEC</span>
                            <i class="mdi mdi-calendar text-muted"></i> {{ $v_devis->getDate_depot_chq_pec() }}
                        </div>
                        <div class="list-group-item">
                            <span class="d-block text-muted">Date dépôt CHQ Part MUT</span>
                            <i class="mdi mdi-calendar text-muted"></i> {{ $v_devis->getDate_depot_chq_part_mut() }}
                        </div>
                        <div class="list-group-item">
                            <span class="d-block text-muted">Date dépôt CHQ RAC</span>
                            <i class="mdi mdi-calendar text-muted"></i> {{ $v_devis->getDate_depot_chq_rac() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appels et Mails Section -->
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title text-primary">Appels et Mails</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span>1er appel: {{ $v_devis->getNote_1er_appel() }}</span>
                            <span class="text-muted small">{{ $v_devis->getDate_1er_appel() }}</span>
                        </li>
                        <li class="list-group-item">
                            <span>2ème appel: {{ $v_devis->getNote_2eme_appel() }}</span>
                            <span class="text-muted small">{{ $v_devis->getDate_2eme_appel() }}</span>
                        </li>
                        <li class="list-group-item">
                            <span>3ème appel: {{ $v_devis->getNote_3eme_appel() }}</span>
                            <span class="text-muted small">{{ $v_devis->getDate_3eme_appel() }}</span>
                        </li>
                        <li class="list-group-item">
                            <span>Email envoyé</span>
                            <span class="text-muted small">{{ $v_devis->getDate_envoi_mail() }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


@endsection
