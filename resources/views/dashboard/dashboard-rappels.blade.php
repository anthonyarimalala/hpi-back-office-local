@extends('layouts.app')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" href="{{ asset('dashboard/overview') }}" role="tab" aria-controls="overview" aria-selected="false">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" href="{{ asset('dashboard/c-a') }}" role="tab" aria-selected="false">CA</a>
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
                        <div class="col-md-12 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h4 class="card-title card-title-dash">Appels et Mails Aujourd'hui</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Dossier</th>
                                                <th>Patient</th>
                                                <th>Date 1er appel</th>
                                                <th>Note 1er appel</th>
                                                <th>Date 2ème appel</th>
                                                <th>Note 2ème appel</th>
                                                <th>Date 3ème appel</th>
                                                <th>Note 3ème appel</th>
                                                <th>Date d'envoi mail</th>
                                            </tr>
                                            </thead>
                                            <tbody  id="reglement-body">
                                                @foreach($appels_mails_ajdss as $dev)
                                                    @php
                                                        $today = \Carbon\Carbon::today()->format('Y-m-d');
                                                        $couleur1erAppel = null;
                                                        $couleur2emeAppel = null;
                                                        $couleur3emeAppel = null;
                                                        $couleurMail = null;
                                                        if ($dev->date_1er_appel == $today) $couleur1erAppel = '#B7A28A';
                                                        if ($dev->note_1er_appel != null && $dev->note_1er_appel != '') $couleur1erAppel = '#73E55D';
                                                        if ($dev->date_2eme_appel == $today) $couleur2emeAppel = '#B7A28A';
                                                        if ($dev->note_2eme_appel != null && $dev->note_2eme_appel != '') $couleur2emeAppel = '#73E55D';
                                                        if ($dev->date_3eme_appel == $today) $couleur3emeAppel = '#B7A28A';
                                                        if ($dev->note_3eme_appel != null && $dev->note_3eme_appel != '') $couleur3emeAppel = '#73E55D';
                                                        if ($dev->date_envoi_mail == $today) $couleurMail = '#B7A28A';
                                                        if ($dev->email_sent == 1) $couleurMail = '#73E55D';
                                                    @endphp
                                                    <tr style="background-color: {{ $dev->couleur }}"
                                                        onmouseover="this.style.backgroundColor='#d3d3d3';"
                                                        onmouseout="this.style.backgroundColor='{{ $dev->couleur }}';"
                                                        onclick="window.location.href='{{ asset($dev->dossier.'/devis/'.$dev->id_devis.'/modifier')  }}';">
                                                        <td>{{ $dev->dossier }}</td>
                                                        <td>{{ $dev->nom }}</td>
                                                        <td style="background-color: {{ $couleur1erAppel }}">
                                                            {{ $dev->date_1er_appel ? \Carbon\Carbon::parse($dev->date_1er_appel)->format('d-m-Y') : '' }}
                                                        </td>
                                                        <td>{{ $dev->note_1er_appel }}</td>
                                                        <td style="background-color: {{ $couleur2emeAppel }}">
                                                            {{ $dev->date_2eme_appel ? \Carbon\Carbon::parse($dev->date_2eme_appel)->format('d-m-Y') : '' }}
                                                        </td>
                                                        <td>{{ $dev->note_2eme_appel }}</td>
                                                        <td style="background-color: {{ $couleur3emeAppel }}">
                                                            {{ $dev->date_3eme_appel ? \Carbon\Carbon::parse($dev->date_3eme_appel)->format('d-m-Y') : '' }}
                                                        </td>
                                                        <td>{{ $dev->note_3eme_appel }}</td>
                                                        <td style="background-color: {{ $couleurMail }}">
                                                            {{ $dev->date_envoi_mail ? \Carbon\Carbon::parse($dev->date_envoi_mail)->format('d-m-Y') : '' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

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
