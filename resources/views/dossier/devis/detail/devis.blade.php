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
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#devis" role="tab" aria-controls="overview" aria-selected="true">Devis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" href="{{ asset($v_devis->dossier.'/prothese/'.$v_devis->id_devis.'/acte'.$id_acte.'/detail') }}" role="tab" aria-selected="false">Prothèse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" href="{{ asset($v_devis->dossier.'/cheque/'.$v_devis->id_devis.'/acte'.$id_acte.'/detail') }}" role="tab" aria-selected="false">Chèque</a>
            </li>
        </ul>
    </div>
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <h1 class="display-4 me-3">Devis dossier: {{ $v_devis->dossier }}</h1>
            <a href="{{ asset($v_devis->dossier.'/devis/'.$v_devis->id_devis.'/acte'.$id_acte.'/modifier') }}">
                <button class="btn btn-primary btn-lg text-white" type="button"><i class="mdi mdi-pen"></i>Modifier</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header text-white">
                    <h4 class="card-title mb-0" style="color: whitesmoke">Info Devis</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($v_devis->etat != '' && $v_devis->etat != null)
                                <h3 class="p-3 text-white" style="background-color: {{ $v_devis->couleur }};">{{ $v_devis->etat }}</h3>
                            @endif
                            <p class="card-subtitle card-subtitle-dash"> Dossier: {{ $v_devis->dossier }}</p>
                            <p class="card-subtitle card-subtitle-dash"> Nom: {{ $v_devis->nom }}</p>
                            <p class="card-subtitle card-subtitle-dash"> Status: {{ $v_devis->status }}</p>
                            <p class="card-subtitle card-subtitle-dash"> Mutuelle: {{ $v_devis->mutuelle }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-dark">Date: @if($v_devis->date != null) {{ \Carbon\Carbon::parse($v_devis->date)->translatedFormat('d F Y') }} @endif</p>
                            <p class="text-dark">Montant: {{ number_format($v_devis->montant, 2, ',', ' ') }} Euro </p>
                            @if($v_devis->devis_signe == 'oui')
                                <p class="text-light bg-success pl-1">Signé</p>
                            @else
                                <p class="text-light bg-danger pl-1">Non Signé</p>
                            @endif
                            <p class="text-dark">Praticien: {{ $v_devis->getPraticien() }} </p>
                            <p class="text-dark">Observation: {{ $v_devis->getObservation() }} </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-white">
                    <h4 class="card-title mb-0" style="color: whitesmoke">Retour mutuelle</h4>
                </div>
                <div class="card-body">
                    <div class="list align-items-center border-bottom py-2">
                        <div class="wrapper w-100">
                            <p class="mb-2 font-weight-medium">
                                Envoi PEC
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-calendar text-muted me-1"></i>
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->getDate_paiement_cb_ou_esp() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list align-items-center border-bottom py-2">
                        <div class="wrapper w-100">
                            <p class="mb-2 font-weight-medium">
                                Fin validité PEC
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-calendar text-muted me-1"></i>
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->getDate_depot_chq_pec() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list d-flex align-items-center border-bottom py-2">
                        <div class="wrapper w-50 px-2">
                            <p class="mb-2 font-weight-medium">Part sécu</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->getPart_secu() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper w-50 px-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->part_secu_status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="list d-flex align-items-center border-bottom py-2">
                        <div class="wrapper w-50 px-2">
                            <p class="mb-2 font-weight-medium">Part mutuelle</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->getPart_mutuelle() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper w-50 px-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->part_mutuelle_status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="list d-flex align-items-center border-bottom py-2">
                        <div class="wrapper w-50 px-2">
                            <p class="mb-2 font-weight-medium">Part RAC</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->getPart_rac() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper w-50 px-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->part_rac_status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-white">
                    <h4 class="card-title mb-0" style="color: whitesmoke">Règlements</h4>
                </div>
                <div class="card-body">
                    <div class="container">
                        <!-- Date paiement par CB ou Esp -->
                        <div class="row align-items-center border-bottom py-2">
                            <div class="col-12">
                                <p class="mb-2 font-weight-medium">CB</p>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->reglement_cb }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center border-bottom py-2">
                            <div class="col-12">
                                <p class="mb-2 font-weight-medium">Espece</p>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->reglement_espece }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center border-bottom py-2">
                            <div class="col-12">
                                <p class="mb-2 font-weight-medium">Date paiement par CB ou Esp</p>
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-calendar text-muted me-2"></i>
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->getDate_paiement_cb_ou_esp() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Date depot CHQ PEC -->
                        <div class="row align-items-center border-bottom py-2">
                            <div class="col-12">
                                <p class="mb-2 font-weight-medium">Date dépôt CHQ PEC</p>
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-calendar text-muted me-2"></i>
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->getDate_depot_chq_pec() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Date depot CHQ Part MUT -->
                        <div class="row align-items-center border-bottom py-2">
                            <div class="col-12">
                                <p class="mb-2 font-weight-medium">Date dépôt CHQ Part MUT</p>
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-calendar text-muted me-2"></i>
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->getDate_depot_chq_part_mut() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Date depot CHQ RAC -->
                        <div class="row align-items-center py-2">
                            <div class="col-12">
                                <p class="mb-2 font-weight-medium">Date dépôt CHQ RAC</p>
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-calendar text-muted me-2"></i>
                                    <p class="mb-0 text-small text-muted">{{ $v_devis->getDate_depot_chq_rac() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-white">
                    <h4 class="card-title mb-0" style="color: whitesmoke">Appels et mail</h4>
                </div>
                <div class="card-body">
                    <div class="list-wrapper">
                        <ul class="todo-list todo-list-rounded">
                            <li class="d-block">
                                <div class="form-check w-100">
                                    <label class="form-check-label">
                                        {{ $v_devis->getNote_1er_appel() }}
                                        <i class="input-helper"></i></label>
                                    <div class="d-flex mt-2">
                                        <div class="ps-4 text-small me-3"><i class="mdi mdi-calendar text-muted me-1"></i> {{ $v_devis->getDate_1er_appel() }}</div>
                                        <div @if($v_devis->note_1er_appel == null || $v_devis->note_1er_appel == '') class="badge badge-opacity-warning me-3" @else class="badge badge-opacity-success me-3" @endif >1er appel</div>
                                    </div>
                                </div>
                            </li>
                            <li class="d-block">
                                <div class="form-check w-100">
                                    <label class="form-check-label">
                                        {{ $v_devis->getNote_2eme_appel() }}
                                        <i class="input-helper"></i></label>
                                    <div class="d-flex mt-2">
                                        <div class="ps-4 text-small me-3"><i class="mdi mdi-calendar text-muted me-1"></i> {{ $v_devis->getDate_2eme_appel() }}</div>
                                        <div @if($v_devis->note_2eme_appel == null || $v_devis->note_2eme_appel == '') class="badge badge-opacity-warning me-3" @else class="badge badge-opacity-success me-3" @endif>2ème appel</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="form-check w-100">
                                    <label class="form-check-label">
                                        {{ $v_devis->getNote_3eme_appel() }}
                                        <i class="input-helper"></i></label>
                                    <div class="d-flex mt-2">
                                        <div class="ps-4 text-small me-3"><i class="mdi mdi-calendar text-muted me-1"></i>{{ $v_devis->getDate_3eme_appel() }}</div>
                                        <div @if($v_devis->note_3eme_appel == null || $v_devis->note_3eme_appel == '') class="badge badge-opacity-warning me-3" @else class="badge badge-opacity-success me-3" @endif>3ème appel</div>
                                    </div>
                                </div>
                            </li>
                            <li class="border-bottom-0">
                                <div class="form-check w-100">
                                    <div class="d-flex mt-2">
                                        <div class="ps-4 text-small me-3"><i class="mdi mdi-calendar text-muted me-1"></i>{{ $v_devis->getDate_envoi_mail() }}</div>
                                        <div class="badge badge-opacity-warning me-3">Email</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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
