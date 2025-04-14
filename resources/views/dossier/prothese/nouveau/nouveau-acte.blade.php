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
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-5">Nouveau Acte(travail demandé) - Dossier: {{ $m_devis->dossier }}</h1>
        </div>
    </div>

    <form action="{{ asset($m_devis->dossier.'/prothese/'.$m_devis->id.'/acte'.$id_acte.'/nouveau-acte') }}" method="POST">
        @csrf
        <input name="dossier" value="{{ $m_devis->dossier }}" hidden>
        <input name="id_devis" value="{{ $m_devis->id }}" hidden>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-header text-white">
                        <div class="d-sm-flex justify-content-between align-items-start">
                            <h4 class="card-title mb-0" style="color: whitesmoke">Empreintes</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                <tr>
                                    <th>Laboratoire</th>
                                    <th>Date Empreinte</th>
                                    <th>Date Envoi Labo</th>
                                    <th>Travail Demandé</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" name="laboratoire" value="{{ $m_prothese_empreinte->laboratoire }}" placeholder="Laboratoire" /></td>
                                    <td><input type="date" class="form-control" name="date_empreinte" value="{{ $m_prothese_empreinte->date_empreinte ? \Carbon\Carbon::parse($m_prothese_empreinte->date_empreinte)->format('Y-m-d'):'' }}" placeholder="Date Empreinte" /></td>
                                    <td><input type="date" class="form-control" name="date_envoi_labo" value="{{ $m_prothese_empreinte->date_envoi_labo ? \Carbon\Carbon::parse($m_prothese_empreinte->date_envoi_labo)->format('Y-m-d'):'' }}" placeholder="Date Envoi Labo" /></td>
                                    <td><textarea class="form-control" name="travail_demande" rows="3" style="height: 100px" placeholder="Travail demandés"></textarea></td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead class="table-light">
                                <tr>
                                    <th>Montant</th>
                                    <th>Numéro Dent</th>
                                    <th>Observations</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="number" class="form-control" step="0.01" name="montant_acte" value="" placeholder="Montant" min="0"/></td>
                                    <td><textarea class="form-control" name="numero_dent" rows="3" style="height: 100px" placeholder="Numéro Dent"></textarea></td>
                                    <td><textarea class="form-control" name="observations" rows="3" style="height: 100px" placeholder="Observations"></textarea></td>
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
                        <div class="table-responsive">
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
                                    <td><input type="date" class="form-control" name="date_livraison" value="" placeholder="Date Livraison" /></td>
                                    <td><input type="text" class="form-control" name="numero_suivi" value="" placeholder="Numéro Suivi" /></td>
                                    <td><input type="text" class="form-control" name="numero_facture_labo" value="" placeholder="Numéro Facture Labo" /></td>
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
                        <div class="d-sm-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="card-title mb-0" style="color: whitesmoke">Travaux</h4>
                            </div>
                            <div>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#posestatusModal">
                                    <i class="mdi mdi-cogs mr-2" style="font-size: 1.5rem;"></i> Statut
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
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
                                    <td><input type="date" class="form-control" name="date_pose_prevue" value="" placeholder="Date Pose Prévue" /></td>
                                    <td>
                                        <select class="form-select" name="id_pose_statut">
                                            <option  selected disabled>Selectionner un status</option>
                                            @foreach($status_poses as $sp)
                                                <option value="{{ $sp->id }}">{{ $sp->travaux_status }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="date_pose_reel" value="" placeholder="Date Pose Réel" /></td>
                                    <td><input type="text" class="form-control" name="organisme_payeur" value="" placeholder="Organisme Payeur" /></td>
                                    <td><input type="number" class="form-control" step="0.01" name="montant_encaisse" value="" placeholder="Montant Encaissé" min="0"/></td>
                                    <td><input type="date" class="form-control" name="date_controle_paiement" value="" placeholder="Date Contrôle Paiement" /></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center mt-4">
                <button type="submit" class="btn btn-primary" style="color: whitesmoke">Mettre à jour</button>
            </div>
        </div>
    </form>
    @include('modals.pose-status-modal')
@endsection
