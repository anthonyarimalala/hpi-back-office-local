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
    <div class="d-sm-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" href="{{ asset($v_prothese->dossier.'/devis/'.$v_prothese->id_devis.'/detail') }}" role="tab" aria-controls="overview" aria-selected="false">Devis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#prothese" role="tab" aria-selected="true">Prothèse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" href="{{ asset($v_prothese->dossier.'/cheque/'.$v_prothese->id_devis.'/detail') }}" role="tab" aria-selected="false">Chèque</a>
            </li>
        </ul>
    </div>

    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-5">Modifier Prothèse - Dossier: {{ $v_prothese->dossier }}</h1>
        </div>
    </div>

    <form action="{{ asset('modifier-prothese') }}" method="POST">
        @csrf
        <input name="dossier" value="{{ $v_prothese->dossier }}" hidden>
        <input name="id_devis" value="{{ $v_prothese->id_devis }}" hidden>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header text-white">
                    <h4 class="card-title mb-0" style="color: whitesmoke">Empreintes</h4>
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
                                <th>Numéro Dent</th>
                                <th>Observations</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="laboratoire" value="{{ $v_prothese->laboratoire }}" placeholder="Laboratoire" /></td>
                                <td><input type="date" class="form-control" name="date_empreinte" value="{{ $v_prothese->date_empreinte ? \Carbon\Carbon::parse($v_prothese->date_empreinte)->format('Y-m-d'):'' }}" placeholder="Date Empreinte" /></td>
                                <td><input type="date" class="form-control" name="date_envoi_labo" value="{{ $v_prothese->date_envoi_labo ? \Carbon\Carbon::parse($v_prothese->date_envoi_labo)->format('Y-m-d'):'' }}" placeholder="Date Envoi Labo" /></td>
                                <td><textarea class="form-control" name="travail_demande" rows="3" style="height: 100px" placeholder="Travail demandés">{{ $v_prothese->travail_demande }}</textarea></td>
                                <td><textarea class="form-control" name="numero_dent" rows="3" style="height: 100px" placeholder="Numéro Dent">{{ $v_prothese->numero_dent }}</textarea></td>
                                <td><textarea class="form-control" name="observations" rows="3" style="height: 100px" placeholder="Observations">{{ $v_prothese->observations }}</textarea></td>
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
                                <td><input type="date" class="form-control" name="date_livraison" value="{{ $v_prothese->date_livraison ? \Carbon\Carbon::parse($v_prothese->date_livraison)->format('Y-m-d'):'' }}" placeholder="Date Livraison" /></td>
                                <td><input type="text" class="form-control" name="numero_suivi" value="{{ $v_prothese->numero_suivi }}" placeholder="Numéro Suivi" /></td>
                                <td><input type="text" class="form-control" name="numero_facture_labo" value="{{ $v_prothese->numero_facture_labo }}" placeholder="Numéro Facture Labo" /></td>
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
                                <td><input type="date" class="form-control" name="date_pose_prevue" value="{{ $v_prothese->date_pose_prevue ? \Carbon\Carbon::parse($v_prothese->date_pose_prevue)->format('Y-m-d'):'' }}" placeholder="Date Pose Prévue" /></td>
                                <td><input type="text" class="form-control" name="statut" value="{{ $v_prothese->statut }}" placeholder="Statut" /></td>
                                <td><input type="date" class="form-control" name="date_pose_reel" value="{{ $v_prothese->date_pose_reel ? \Carbon\Carbon::parse($v_prothese->date_pose_reel)->format('Y-m-d'):'' }}" placeholder="Date Pose Réel" /></td>
                                <td><input type="text" class="form-control" name="organisme_payeur" value="{{ $v_prothese->organisme_payeur }}" placeholder="Organisme Payeur" /></td>
                                <td><input type="number" class="form-control" step="0.01" name="montant_encaisse" value="{{ $v_prothese->montant_encaisse }}" placeholder="Montant Encaissé" min="0"/></td>
                                <td><input type="date" class="form-control" name="date_controle_paiement" value="{{ $v_prothese->date_controle_paiement ? \Carbon\Carbon::parse($v_prothese->date_controle_paiement)->format('Y-m-d'):'' }}" placeholder="Date Contrôle Paiement" /></td>
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
@endsection
