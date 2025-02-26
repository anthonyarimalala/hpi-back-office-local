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
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ca_actes_reglements as $ca)
                                        <tr onclick="window.location.href='{{ asset('ca/'.$ca->id.'/'.$ca->dossier.'/modifier') }}';">
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
                                            <td class="text-end">@if($ca->cotation){{ number_format($ca->cotation, 2, ',', ' ') }}@endif</td>
                                            <td style="border-right: 2px solid #000;">{{ $ca->controle_securisation }}</td>
                                            <td class="text-end">@if($ca->ro_part_secu){{ number_format($ca->ro_part_secu, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end">@if($ca->ro_virement_recu){{ number_format($ca->ro_virement_recu, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end">@if($ca->ro_indus_paye){{ number_format($ca->ro_indus_paye, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end">@if($ca->ro_indus_en_attente){{ number_format($ca->ro_indus_en_attente, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="border-right: 2px solid #000;">@if($ca->ro_indus_irrecouvrable){{ number_format($ca->ro_indus_irrecouvrable, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="border-right: 2px solid #000;">@if($ca->part_mutuelle){{ number_format($ca->part_mutuelle, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end">@if($ca->rcs_virement){{ number_format($ca->rcs_virement, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end">@if($ca->rcs_especes){{ number_format($ca->rcs_especes, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="border-right: 2px solid #000;">@if($ca->rcs_cb){{ number_format($ca->rcs_cb, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end">@if($ca->rcsd_cheque){{ number_format($ca->rcsd_cheque, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end">@if($ca->rcsd_especes){{ number_format($ca->rcsd_especes, 2, ',', ' ') }}@endif</td>
                                            <td style="border-right: 2px solid #000;" class="text-end">@if($ca->rcsd_cb){{ number_format($ca->rcsd_cb, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end">@if($ca->rac_part_patient){{ number_format($ca->rac_part_patient, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end">@if($ca->rac_cheque){{ number_format($ca->rac_cheque, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end">@if($ca->rac_especes){{ number_format($ca->rac_especes, 2, ',', ' ') }}@endif</td>
                                            <td class="text-end" style="border-right: 2px solid #000;">@if($ca->rac_cb){{ number_format($ca->rac_cb, 2, ',', ' ') }}@endif</td>
                                            <td>{{ $ca->commentaire ?: 'Aucun commentaire' }}</td>
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
                            <div class="col-md-12 mb-12">
                                <label for="caFile">Action</label>
                                <div>
                                    <input type="radio" id="modification" name="action" value="modification" required>
                                    <label for="modification">Modification</label>

                                    <input type="radio" id="nouveau" name="action" value="nouveau" required>
                                    <label for="nouveau">Nouveau</label>
                                </div>
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
                    <h5 class="modal-title" id="dateModalLabel">Sélectionner la période de modification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="exportForm" action="{{ asset('ca/export') }}" method="GET">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_ca_modif_debut" class="form-label">Date début</label>
                                <input type="date" id="date_ca_modif_debut" name="date_ca_modif_debut" class="form-control" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_ca_modif_fin" class="form-label">Date fin</label>
                                <input type="date" id="date_ca_modif_fin" name="date_ca_modif_fin" class="form-control" value="">
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
@endsection
