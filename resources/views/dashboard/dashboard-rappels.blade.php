@extends('layouts.app')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" href="{{ asset('dashboard/overview') }}" role="tab" aria-controls="overview" aria-selected="false">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" href="{{ asset('dashboard/ca') }}" role="tab" aria-selected="false">CA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="true">Rappels</a>
            </li>
        </ul>
    </div>
    <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
            <div class="row">
                <div class="col-lg-12 d-flex flex-column">
                    <div class="row flex-grow">
                        <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body card-rounded">
                                    <h4 class="card-title  card-title-dash">Validité PEC à venir</h4>
                                    @foreach($appoche_validite_pecs as $avp)
                                        <div class="list align-items-center border-bottom py-2">
                                            <div class="wrapper w-100">
                                                <p class="mb-2 font-weight-medium">
                                                    {{ $avp->nom }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <i class="mdi mdi-calendar text-muted me-1"></i>
                                                        <p class="mb-0 text-small text-muted">{{ $avp->getDate_fin_validite_pec() }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="list align-items-center pt-3">
                                        <div class="wrapper w-100">
                                            <p class="mb-0">
                                                <a href="#" class="fw-bold text-primary">plus <i class="mdi mdi-arrow-right ms-2"></i></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h4 class="card-title card-title-dash">Appels aujourd'hui</h4>
                                    </div>
                                    <ul class="bullet-line-list">
                                        @foreach($appels_mails_ajds as $ama)
                                            <li>
                                                <div class="d-flex justify-content-between">
                                                    <div><span class="text-light-green">{{ $ama->nom }}</span> - {{ $ama->numero_appel }}</div>
                                                    <p>{{ $ama->note_appel }}</p>
                                                </div>
                                            </li>
                                            @if($ama->numero_ap == 3)
                                                <li>
                                                    <div class="d-flex justify-content-between">
                                                        <div><span class="text-light-green">{{ $ama->nom }}</span> - Envoie mail</div>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h4 class="card-title card-title-dash">Reglements aujourd'hui</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Dossier</th>
                                                <th>Patient</th>
                                                <th>Date paiement par CB ou Esp</th>
                                                <th>Date depot CHQ PEC</th>
                                                <th>Date depot CHQ Part MUT</th>
                                                <th>date depot CHQ RAC</th>
                                            </tr>
                                            </thead>
                                            <tbody  id="reglement-body">
                                            @foreach($reglements as $reglement)
                                                <tr>
                                                    <td>{{ $reglement->dossier }}</td>
                                                    <td>{{ $reglement->nom }}</td>
                                                    <td @if($today == $reglement->date_paiement_cb_ou_esp && $reglement->date_paiement_cb_ou_esp) style="background-color: #F2CED5" @endif>
                                                        @if($reglement->date_paiement_cb_ou_esp)
                                                            {{ \Carbon\Carbon::parse($reglement->date_paiement_cb_ou_esp)->format('d-m-Y') }}
                                                        @endif
                                                    </td>

                                                    <td @if($today == $reglement->date_depot_chq_pec && $reglement->date_depot_chq_pec) style="background-color: #F2CED5" @endif>
                                                        @if($reglement->date_depot_chq_pec)
                                                            {{ \Carbon\Carbon::parse($reglement->date_depot_chq_pec)->format('d-m-Y') }}
                                                        @endif
                                                    </td>

                                                    <td @if($today == $reglement->date_depot_chq_part_mut && $reglement->date_depot_chq_part_mut) style="background-color: #F2CED5" @endif>
                                                        @if($reglement->date_depot_chq_part_mut)
                                                            {{ \Carbon\Carbon::parse($reglement->date_depot_chq_part_mut)->format('d-m-Y') }}
                                                        @endif
                                                    </td>

                                                    <td @if($today == $reglement->date_depot_chq_rac && $reglement->date_depot_chq_rac) style="background-color: #F2CED5" @endif>
                                                        @if($reglement->date_depot_chq_rac)
                                                            {{ \Carbon\Carbon::parse($reglement->date_depot_chq_rac)->format('d-m-Y') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
