@extends('layouts.app')
@section('content')
    <style>
        tr:hover {
            background-color: #d3d3d3; /* Couleur de fond au survol */
        }
    </style>
    <div class="row">
        <div class="col-lg-12 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">CA: </h4>
                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('warning'))
                                    <div class="alert alert-warning" role="alert">
                                        {{ session('warning') }}
                                    </div>
                                @endif
                                <div>
                                    <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal" data-bs-target="#fileModal">
                                        <i class="icon-upload"></i> Import
                                    </a>
                                    <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal" data-bs-target="#dateModal">
                                        <i class="icon-download"></i> Export
                                    </a>
                                    <a href="{{ asset('ca/nouveau') }}" class="text-primary">
                                        <i class="mdi mdi-plus mdi-24px">Nouveau</i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-primary" style="color: whitesmoke" data-bs-toggle="modal"
                                        data-bs-target="#modalForm">
                                    Recherche par filtre <i class="mdi mdi-magnify"></i>
                                </button>
                                @if($filters && isset($filters['stringFilters']))
                                    <button class="btn btn-primary" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false" style="color: whitesmoke">
                                        Voir les filtres appliqués <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        @foreach($filters['stringFilters'] as $sf)
                                            <li class="dropdown-item">
                                                <label for="date_pose_prevue_debut" class="form-label"
                                                       style="background-color: #F2CED5">{{ $sf }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div class="col-6">
                                <form action="{{ asset('reinitializeFilterCa') }}" method="GET">
                                    <button class="btn btn-primary" style="color: whitesmoke" type="submit">
                                        Tous
                                    </button>
                                </form>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $ca_actes_reglements->links('pagination::bootstrap-4') }}
                            </div>
                            <div class="table-responsive  mt-1">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th colspan="5" style="background-color: #f3f3f3; text-align: center; border-right: 2px solid #000;"></th>
                                        <th colspan="4" style="background-color: #fff2cc; text-align: center; border-right: 2px solid #000;"></th>
                                        <th colspan="5" style="background-color: #f9cb9c; text-align: center; border-right: 2px solid #000;">RO</th>
                                        <th colspan="1" style="background-color: #cfe2f3; text-align: center; border-right: 2px solid #000;"></th>
                                        <th colspan="3" style="background-color: #6d9eeb; text-align: center; border-right: 2px solid #000;">RC SOINS</th>
                                        <th colspan="3" style="background-color: #76a5af; text-align: center; border-right: 2px solid #000;">RC soins avec DEVIS</th>
                                        <th colspan="4" style="background-color: #d9d2e9; text-align: center; border-right: 2px solid #000;">RAC</th>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #f3f3f3">Date de dernière modif</th>
                                        <th style="background-color: #f3f3f3">N° dossier</th>
                                        <th style="background-color: #f3f3f3">Nom du patient</th>
                                        <th style="background-color: #f3f3f3">Statut</th>
                                        <th style="background-color: #f3f3f3; border-right: 2px solid #000;">Mutuelle</th>
                                        <th style="background-color: #fff2cc">Praticien</th>
                                        <th style="background-color: #fff2cc">Acte</th>
                                        <th style="background-color: #fff2cc">Cotation</th>
                                        <th style="background-color: #fff2cc; border-right: 2px solid #000;">Contrôle sécurisation</th>
                                        <th style="background-color: #f3f3f3">Part Sécu</th>
                                        <th style="background-color: #f3f3f3">Virement reçu</th>
                                        <th style="background-color: #f3f3f3">Indus payé</th>
                                        <th style="background-color: #f3f3f3">Indus en attente</th>
                                        <th style="background-color: #f3f3f3; border-right: 2px solid #000;">Indus irrecouvrable</th>
                                        <th style="background-color: #cfe2f3; border-right: 2px solid #000;">Part Mutuelle</th>
                                        <th style="background-color: #f3f3f3">Virement</th>
                                        <th style="background-color: #f3f3f3">Espèces</th>
                                        <th style="background-color: #f3f3f3; border-right: 2px solid #000;">CB</th>
                                        <th style="background-color: #f3f3f3">Chèque</th>
                                        <th style="background-color: #f3f3f3">Espèces</th>
                                        <th style="background-color: #f3f3f3; border-right: 2px solid #000;">CB</th>
                                        <th style="background-color: #f3f3f3">Part patient</th>
                                        <th style="background-color: #f3f3f3">Chèque</th>
                                        <th style="background-color: #f3f3f3">Espèces</th>
                                        <th style="background-color: #f3f3f3; border-right: 2px solid #000;">CB</th>
                                        <th style="background-color: #f3f3f3">Commentaire</th>
                                        <th style="background-color: #f3f3f3">Date de création</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ca_actes_reglements as $ca)
                                        @php
                                            $cotation_restant = $ca->cotation - $ca->cotation_paye;
                                            $part_secu_restant = ($ca->ro_part_secu ?? 0) - $ca->ro_part_secu_paye;
                                            $part_mutuelle_restant = ($ca->part_mutuelle ?? 0) - $ca->part_mutuelle_paye;
                                            $rac_part_patient_restant = ($ca->rac_part_patient ?? 0) - $ca->rac_part_patient_paye;

                                            $couleur_cotation = "";
                                            $couleur_secu = "";
                                            $couleur_mutuelle = "";
                                            $couleur_rac = "";

                                            if($cotation_restant < 0){$couleur_cotation = "red";}elseif($cotation_restant > 0) {$couleur_cotation = "orange";}
                                            if($part_secu_restant < 0){$couleur_secu = "red";}elseif($part_secu_restant > 0) {$couleur_secu = "orange";}
                                            if($part_mutuelle_restant < 0){$couleur_mutuelle = "red";}elseif($part_mutuelle_restant > 0) {$couleur_mutuelle = "orange";}
                                            if($rac_part_patient_restant < 0){$couleur_rac = "red";}elseif($rac_part_patient_restant > 0){$couleur_rac = "orange";}

                                        @endphp
                                        <tr ondblclick="window.location.href='{{ asset('ca/'.$ca->id_ca_actes_reglement.'/'.$ca->dossier.'/modifier') }}';">
                                            <td>
                                                @if($ca->date_derniere_modif)
                                                    {{ \Carbon\Carbon::parse($ca->date_derniere_modif)->format('Y-m-d') }}
                                                @else
                                                    ...
                                                @endif
                                            </td>
                                            <td>{{ $ca->dossier }}</td>
                                            <td>{{ $ca->nom }}</td>
                                            <td>{{ $ca->statut }}</td>
                                            <td style="border-right: 2px solid #000;">{{ $ca->mutuelle }}</td>
                                            <td>{{ $ca->praticien }}</td>
                                            <td>{{ $ca->nom_acte }}</td>
                                            <td class="text-end" style="background-color: {{ $couleur_cotation }}; ">@if($ca->cotation){{ number_format($ca->cotation, 2, ',', ' ') }}@endif</td>
                                            <td style="border-right: 2px solid #000;">{{ $ca->controle_securisation }}</td>
                                            <!-- -->    <td class="text-end" style="@if($cotation_restant < 0 || $part_secu_restant < 0) background-color: red; @elseif($cotation_restant > 0 || $part_secu_restant > 0) background-color: orange; @endif">
                                                @if($ca->ro_part_secu){{ number_format($ca->ro_part_secu, 2, ',', ' ') }}@endif
                                            </td>
                                            <td class="text-end" style="background-color: {{ $couleur_secu }};">@if($ca->ro_virement_recu){{ number_format($ca->ro_virement_recu, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="background-color: {{ $couleur_secu }};">@if($ca->ro_indus_paye){{ number_format($ca->ro_indus_paye, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="background-color: {{ $couleur_secu }};">@if($ca->ro_indus_en_attente){{ number_format($ca->ro_indus_en_attente, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="background-color: {{ $couleur_secu }}; border-right: 2px solid #000;">@if($ca->ro_indus_irrecouvrable){{ number_format($ca->ro_indus_irrecouvrable, 2, ',', ' ') }}@endif</td>
                                            <!-- -->    <td class="text-end" style="@if($cotation_restant < 0 || $part_mutuelle_restant < 0) background-color: red; @elseif($cotation_restant > 0 || $part_mutuelle_restant > 0) background-color: orange; @endif border-right: 2px solid #000; ">
                                                @if($ca->part_mutuelle){{ number_format($ca->part_mutuelle, 2, ',', ' ') }}@endif
                                            </td>
                                            <td class="text-end" style="background-color: {{ $couleur_mutuelle }};">@if($ca->rcs_virement){{ number_format($ca->rcs_virement, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="background-color: {{ $couleur_mutuelle }};">@if($ca->rcs_especes){{ number_format($ca->rcs_especes, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="background-color: {{ $couleur_mutuelle }}; border-right: 2px solid #000;">@if($ca->rcs_cb){{ number_format($ca->rcs_cb, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="background-color: {{ $couleur_mutuelle }};">@if($ca->rcsd_cheque){{ number_format($ca->rcsd_cheque, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="background-color: {{ $couleur_mutuelle }};">@if($ca->rcsd_especes){{ number_format($ca->rcsd_especes, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="background-color: {{ $couleur_mutuelle }}; border-right: 2px solid #000;">@if($ca->rcsd_cb){{ number_format($ca->rcsd_cb, 2, ',', ' ') }}@endif</td>
                                            <!-- -->    <td class="text-end" style="@if($cotation_restant < 0 || $rac_part_patient_restant < 0 ) background-color: red; @elseif($cotation_restant > 0 || $rac_part_patient_restant > 0) background-color: orange; @endif">
                                                @if($ca->rac_part_patient){{ number_format($ca->rac_part_patient, 2, ',', ' ') }}@endif
                                            </td>
                                            <td class="text-end" style="background-color: {{ $couleur_rac }};">@if($ca->rac_cheque){{ number_format($ca->rac_cheque, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="background-color: {{ $couleur_rac }};">@if($ca->rac_especes){{ number_format($ca->rac_especes, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="background-color: {{ $couleur_rac }}; border-right: 2px solid #000;">@if($ca->rac_cb){{ number_format($ca->rac_cb, 2, ',', ' ') }}@endif</td>
                                            <td>{{ $ca->commentaire ?: 'Aucun commentaire' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($ca->created_at)->format('d-m-Y') }}</td>
                                            <td onclick="event.stopPropagation()"><a href="{{ asset('delete-ca/'. $ca->id ) }}" onclick="return deleteItem('<?= $ca->dossier ?>', '<?= $ca->created_at ?>')">Supprimer</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $ca_actes_reglements->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel">Sélectionner un fichier .xslx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="importForm" action="{{ route('ca.import') }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-12">
                                <label for="caFile">Fichier Excel</label>
                                <input type="file" class="form-control" id="caFile" name="caFile" accept=".xlsx">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" id="exportBtn">Importer</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateModalLabel">Sélectionner la période</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="exportForm" action="{{ asset('ca/export') }}" method="GET">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_ca_modif_debut" class="form-label">Date de création début</label>
                                <input type="date" id="date_ca_create_debut" name="date_ca_create_debut" class="form-control" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_ca_modif_fin" class="form-label">Date de création fin</label>
                                <input type="date" id="date_ca_create_fin" name="date_ca_create_fin" class="form-control" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_ca_modif_debut" class="form-label">Date de modification début</label>
                                <input type="date" id="date_ca_modif_debut" name="date_ca_modif_debut" class="form-control" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_ca_modif_fin" class="form-label">Date de modification fin</label>
                                <input type="date" id="date_ca_modif_fin" name="date_ca_modif_fin" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-12 mb-12">
                            <div>
                                <input type="checkbox" id="withFilters" name="withFilters[]" value="oui">
                                <label for="withFilters">Prendre en compte les filtres</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" id="exportBtn">Exporter</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Recherche Par Filtre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ asset('getFilterCa') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="row col-md-6">
                                <h4 class="text-center mb-4"
                                    style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Date de CA</h4>
                                <div class="col-md-12 mb-3">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="color: whitesmoke; background-color: #2f8ab9;">
                                            Date de CA
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li class="dropdown-item">
                                                <label for="date_ca_debut" class="form-label">Date début</label>
                                                <input type="date" id="date_ca_debut" name="date_ca_debut"
                                                       class="form-control" @if($filters) value="{{ $filters['date_ca_debut'] }}" @endif>
                                            </li>
                                            <li class="dropdown-item">
                                                <label for="date_ca_fin" class="form-label">Date fin</label>
                                                <input type="date" id="date_ca_fin" name="date_ca_fin"
                                                       class="form-control" @if($filters) value="{{ $filters['date_ca_fin'] }}" @endif>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-6">
                                <h4 class="text-center mb-4"
                                    style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Date de dernière modification</h4>
                                <div class="col-md-12 mb-3">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="color: whitesmoke; background-color: #2f8ab9;">
                                            Date de dèrnière modification
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li class="dropdown-item">
                                                <label for="date_derniere_modif_debut" class="form-label">Date début</label>
                                                <input type="date" id="date_derniere_modif_debut" name="date_derniere_modif_debut"
                                                       class="form-control" @if($filters) value="{{ $filters['date_derniere_modif_debut'] }}" @endif>
                                            </li>
                                            <li class="dropdown-item">
                                                <label for="date_derniere_modif_fin" class="form-label">Date fin</label>
                                                <input type="date" id="date_derniere_modif_fin" name="date_derniere_modif_fin"
                                                       class="form-control" @if($filters) value="{{ $filters['date_derniere_modif_fin'] }}" @endif>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-4">
                                <h4 class="text-center mb-4"
                                    style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Status</h4>
                                <div class="col-md-12 mb-3">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="color: whitesmoke; background-color: #2f8ab9;">
                                            Status
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @foreach ($dossier_statuss as $st)
                                                <li class="dropdown-item">
                                                    <label
                                                        for="status"></label><input
                                                        type="checkbox" class="form-check-input"
                                                        id="status" name="status[]"
                                                        value="{{ $st->status }}"
                                                        @if($filters && isset($filters['status']) && in_array($st->status, $filters['status']))
                                                            checked
                                                        @endif
                                                    >
                                                    {{ $st->status }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-4">
                                <h4 class="text-center mb-4"
                                    style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Praticiens</h4>
                                <div class="col-md-12 mb-3">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="color: whitesmoke; background-color: #2f8ab9;">
                                            Praticiens
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @foreach ($praticiens as $pr)
                                                <li class="dropdown-item">
                                                    <label
                                                        for="praticien"></label><input
                                                        type="checkbox" class="form-check-input"
                                                        id="praticien" name="praticiens[]"
                                                        value="{{ $pr->praticien }}"
                                                        @if($filters && isset($filters['praticiens']) && in_array($pr->praticien, $filters['praticiens']))
                                                            checked
                                                        @endif
                                                    >
                                                    {{ $pr->praticien }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-4">
                                <h4 class="text-center mb-4"
                                    style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Cotation</h4>
                                <div class="col-md-12 mb-3">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="color: whitesmoke; background-color: #2f8ab9;">
                                            Cotations
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li class="dropdown-item">
                                                <label for="montant_min_cotation" class="form-label">Montant Min</label>
                                                <input type="number" step="0.01" id="montant_min_cotation" name="montant_min_cotation"
                                                       class="form-control" @if($filters) value="{{ $filters['montant_min_cotation'] }}" @endif>
                                            </li>
                                            <li class="dropdown-item">
                                                <label for="montant_max_cotation" class="form-label">Montant Max</label>
                                                <input type="number" step="0.01" id="montant_max_cotation" name="montant_max_cotation"
                                                       class="form-control" @if($filters) value="{{ $filters['montant_max_cotation'] }}" @endif>
                                            </li>
                                            <li class="dropdown-item">
                                                <label>
                                                    <input type="checkbox" class="form-check-input"
                                                           name="non_regle_cotation[]" value="non_regle_cotation" @if($filters) @if(count($filters['non_regle_cotation'])>0) checked @endif @endif>
                                                </label> Non réglé
                                            </li>
                                            <li class="dropdown-item">
                                                <label>
                                                    <input type="checkbox" class="form-check-input"
                                                           name="regle_cotation[]" value="regle_cotation" @if($filters) @if(count($filters['regle_cotation'])>0) checked @endif @endif>
                                                </label> Réglé
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row col-md-4">
                                <h4 class="text-center mb-4"
                                    style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Part Sécu</h4>
                                <div class="col-md-12 mb-3">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="color: whitesmoke; background-color: #2f8ab9;">
                                            Part sécu
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li class="dropdown-item">
                                                <label for="montant_min_secu" class="form-label">Montant Min</label>
                                                <input type="number" step="0.01" id="montant_min_secu" name="montant_min_secu"
                                                       class="form-control" @if($filters) value="{{ $filters['montant_min_secu'] }}" @endif>
                                            </li>
                                            <li class="dropdown-item">
                                                <label for="montant_max_secu" class="form-label">Montant Max</label>
                                                <input type="number" step="0.01" id="montant_max_secu" name="montant_max_secu"
                                                       class="form-control" @if($filters) value="{{ $filters['montant_max_secu'] }}" @endif>
                                            </li>
                                            <li class="dropdown-item">
                                                <label>
                                                    <input type="checkbox" class="form-check-input"
                                                           name="non_regle_secu[]" value="non_regle_secu" @if($filters) @if(count($filters['non_regle_secu'])>0)  checked @endif @endif>
                                                </label> Non réglé
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-4">
                                <h4 class="text-center mb-4"
                                    style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Part Mut</h4>
                                <div class="col-md-12 mb-3">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="color: whitesmoke; background-color: #2f8ab9;">
                                            Status
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li class="dropdown-item">
                                                <label for="montant_min_mut" class="form-label">Montant Min</label>
                                                <input type="number" step="0.01" id="montant_min_mut" name="montant_min_mut"
                                                       class="form-control" @if($filters) value="{{ $filters['montant_min_mut'] }}" @endif>
                                            </li>
                                            <li class="dropdown-item">
                                                <label for="montant_max_mut" class="form-label">Montant Max</label>
                                                <input type="number" step="0.01" id="montant_max_mut" name="montant_max_mut"
                                                       class="form-control" @if($filters) value="{{ $filters['montant_max_mut'] }}" @endif>
                                            </li>
                                            <li class="dropdown-item">
                                                <label>
                                                    <input type="checkbox" class="form-check-input"
                                                           name="non_regle_mut[]" value="non_regle_mut" @if($filters) @if(count($filters['non_regle_mut'])>0)  checked @endif @endif>
                                                </label> Non réglé
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-4">
                                <h4 class="text-center mb-4"
                                    style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Part Patient</h4>
                                <div class="col-md-12 mb-3">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="color: whitesmoke; background-color: #2f8ab9;">
                                            Praticiens
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li class="dropdown-item">
                                                <label for="montant_min_patient" class="form-label">Montant Min</label>
                                                <input type="number" step="0.01" id="montant_min_patient" name="montant_min_patient"
                                                       class="form-control" @if($filters) value="{{ $filters['montant_min_patient'] }}" @endif>
                                            </li>
                                            <li class="dropdown-item">
                                                <label for="montant_max_patient" class="form-label">Montant Max</label>
                                                <input type="number" step="0.01" id="montant_max_patient" name="montant_max_patient"
                                                       class="form-control" @if($filters) value="{{ $filters['montant_max_patient'] }}" @endif>
                                            </li>
                                            <li class="dropdown-item">
                                                <label>
                                                    <input type="checkbox" class="form-check-input"
                                                           name="non_regle_patient[]" value="non_regle_patient" @if($filters) @if(count($filters['non_regle_patient'])>0)  checked @endif @endif>
                                                </label> Non réglé
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success" style="color: whitesmoke">Rechercher</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteItem(dossier, dateCreated) {
            return confirm(`Voulez-vous vraiment supprimer cela ?\nDossier: ${dossier}\nDate: ${dateCreated}`);
        }
    </script>
@endsection
