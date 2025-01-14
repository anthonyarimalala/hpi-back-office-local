@extends(session('layout') ?? 'layouts.app')
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
        <div class="col-12 text-center">
            <h1 class="display-4">Devis dossier: {{ $v_devis->dossier }}</h1>
            <div>
                <a href="{{ asset($v_devis->dossier.'/devis/'.$v_devis->id_devis.'/modifier') }}">
                    <button class="btn btn-primary btn-lg text-white mb-0 me-0" type="button"><i class="mdi mdi-pen"></i>Modifier</button>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    @if($v_devis->etat != '' && $v_devis->etat != null)
                                        <h3 class="p-3 text-white" style="background-color: {{ $v_devis->couleur }};">{{ $v_devis->etat }}</h3>
                                    @endif
                                    <h4 class="card-title card-title-dash">Info Patient</h4>
                                    <p class="card-subtitle card-subtitle-dash"> Nom: {{ $v_devis->nom }}</p>
                                    <p class="card-subtitle card-subtitle-dash"> Status: {{ $v_devis->status }}</p>
                                    <p class="card-subtitle card-subtitle-dash">
                                        Mutuelle:
                                        {{ $mutuelles->pluck('mutuelle')->join(' ') }}
                                    </p>


                                </div>
                            </div>
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Devis</h4>
                                    <p class="card-subtitle card-subtitle-dash"> Date: @if($v_devis->date != null) {{ \Carbon\Carbon::parse($v_devis->date)->translatedFormat('d F Y') }} @endif</p>
                                </div>

                                <div>
                                    <br>
                                    @if($v_devis->devis_signe == 'oui')
                                        <button type="button" class="btn btn-success btn-rounded btn-fw" style="color: whitesmoke">Signé</button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-rounded btn-fw" style="color: whitesmoke">Non Signé</button>
                                    @endif
                                </div>

                            </div>
                            <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                <div class="d-sm-flex align-items-center mt-4 justify-content-between"><h2 class="me-2 fw-bold">{{ number_format($v_devis->montant, 2, ',', ' ') }}</h2><h4 class="me-2">Euro</h4></div>
                                <div class="me-3"><div id="marketing-overview-legend"><div class="chartjs-legend">Praticien: {{ $v_devis->getPraticien() }} </div></div></div>
                            </div>
                            <br>
                            <div class="">
                                <u>Observation: </u> <br>
                                {{ $v_devis->getObservation() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Retour mutuelle</h4>
                                    <p class="card-subtitle card-subtitle-dash">Charge d'acceuil</p>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Envoi PEC</th>
                                        <th>Fin validité PEC</th>
                                        <th>Part mutuelle</th>
                                        <th>Part RAC</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="py-1">
                                            <p>{{ $v_devis->getDate_envoi_pec() }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $v_devis->getDate_fin_validite_pec() }}</p>
                                        </td>

                                        <td>
                                            <p>{{ $v_devis->getPart_mutuelle() }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $v_devis->getPart_rac() }}</p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row flex-grow">
                <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body card-rounded">
                            <h4 class="card-title  card-title-dash">Règlements</h4>
                            <div class="list align-items-center border-bottom py-2">
                                <div class="wrapper w-100">
                                    <p class="mb-2 font-weight-medium">
                                        Date paiement par CB ou Esp
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
                                        Date depot CHQ PEC
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-calendar text-muted me-1"></i>
                                            <p class="mb-0 text-small text-muted">{{ $v_devis->getDate_depot_chq_pec() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list align-items-center border-bottom py-2">
                                <div class="wrapper w-100">
                                    <p class="mb-2 font-weight-medium">
                                        Date depot CHQ Part MUT
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-calendar text-muted me-1"></i>
                                            <p class="mb-0 text-small text-muted">{{ $v_devis->getDate_depot_chq_part_mut() }}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="list align-items-center border-bottom py-2">
                                <div class="wrapper w-100">
                                    <p class="mb-2 font-weight-medium">
                                        date depot CHQ RAC
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-calendar text-muted me-1"></i>
                                            <p class="mb-0 text-small text-muted">{{ $v_devis->getDate_depot_chq_rac() }}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex flex-column">
            <div class="col-12 grid-margin stretch-card">
                <div class="card card-rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title card-title-dash">Appels et mail</h4>
                                </div>
                            </div>
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
            </div>

        </div>
    </div>
@endsection
