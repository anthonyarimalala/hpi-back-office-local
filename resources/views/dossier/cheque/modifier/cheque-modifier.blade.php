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
                <a class="nav-link" id="home-tab" href="{{ asset($v_cheque->dossier.'/devis/'.$v_cheque->id_devis.'/acte'.$id_acte.'/detail') }}" role="tab" aria-controls="overview" aria-selected="false">Devis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" href="{{ asset($v_cheque->dossier.'/prothese/'.$v_cheque->id_devis.'/acte'.$id_acte.'/detail') }}" role="tab" aria-selected="false">Prothèse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="contact-tab" data-bs-toggle="tab" href="#cheque" role="tab" aria-selected="true">Chèque</a>
            </li>
        </ul>
    </div>
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">Modifier chèque, dossier: {{ $v_cheque->dossier }}</h1>
        </div>
    </div>
    <form action="{{ asset('modifier-cheque/acte'.$id_acte) }}" method="POST">
        @csrf
        <label>
            <input type="number" name="id_devis" value="{{ $v_cheque->id_devis }}" hidden>
            <input type="text" name="dossier" value="{{ $v_cheque->dossier }}" hidden>
        </label>
        <div class="row">
        <div class="col-md-10 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-white">
                    <h4 class="card-title mb-0" style="color: whitesmoke">Info chèque</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <div class="row">
                                    <label for="numero_cheque" class="col-sm-3 col-form-label">N°</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="numero_cheque" name="numero_cheque" placeholder="Numéro" value="{{ $v_cheque->numero_cheque }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="montant_cheque" class="col-sm-3 col-form-label">Montant du chèque</label>
                                    <div class="col-sm-9">
                                        <input type="number" step="0.01" class="form-control" id="montant_cheque" name="montant_cheque" placeholder="Montant du chèque" min="0" value="{{ $v_cheque->montant_cheque }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="nom_document" class="col-sm-3 col-form-label">Nom document</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nom_document" name="nom_document" placeholder="Nom document" value="{{ $v_cheque->nom_document }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="nature_cheque" class="col-sm-3 col-form-label">Nature du chèque</label>
                                    <div class="col-sm-9">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <select class="form-select" id="nature_cheque" name="nature_cheque">
                                                    <option value="" disabled selected>Choisir la nature du chèque</option>
                                                    @foreach($nature_cheques as $nc)
                                                        <option value="{{ $nc->nature_cheque }}" @if($nc->nature_cheque == $v_cheque->nature_cheque) selected @endif>{{ $nc->nature_cheque }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#naturechequeModal">
                                                    <i class="mdi mdi-cogs mr-2" style="font-size: 2rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <label for="travaux_sur_devis" class="col-sm-3 col-form-label">Travaux sur devis</label>
                                    <div class="col-sm-9">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <select class="form-select" id="travaux_sur_devis" name="travaux_sur_devis">
                                                    <option value="" disabled selected>Travaux sur devis</option>
                                                    @foreach($travaux_sur_devis as $td)
                                                        <option value="{{ $td->travaux_sur_devis }}" @if($td->travaux_sur_devis == $v_cheque->travaux_sur_devis) selected @endif>{{ $td->travaux_sur_devis }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#travauxdevisModal">
                                                    <i class="mdi mdi-cogs mr-2" style="font-size: 2rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <label for="situation_cheque" class="col-sm-3 col-form-label">Situation</label>
                                    <div class="col-sm-9">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <select class="form-select" id="situation_cheque" name="situation_cheque">
                                                    <option value="" disabled selected>Situation</option>
                                                    @foreach($situation_cheques as $sc)
                                                        <option value="{{ $sc->situation_cheque }}" @if($sc->situation_cheque == $v_cheque->situation_cheque) selected @endif>{{ $sc->situation_cheque }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#situationchequeModal">
                                                    <i class="mdi mdi-cogs mr-2" style="font-size: 2rem;"></i>
                                                </a>
                                            </div>
                                </div>
                                    </div>
                                </div>
                            </address>
                        </div>
                        <div class="col-md-6">
                            <address>
                                <div class="form-group">
                                    <label for="date_encaissement_cheque">Date d'encaissement</label>
                                    <input type="date" class="form-control" id="date_encaissement_cheque" name="date_encaissement_cheque" value="{{ $v_cheque->date_encaissement_cheque ? \Carbon\Carbon::parse($v_cheque->date_encaissement_cheque)->format('Y-m-d'):'' }}">
                                </div>
                                <div class="form-group">
                                    <label for="date_1er_acte">Date de 1er acte</label>
                                    <input type="date" class="form-control" id="date_1er_acte" name="date_1er_acte" value="{{ $v_cheque->date_1er_acte ? \Carbon\Carbon::parse($v_cheque->date_1er_acte)->format('Y-m-d'):'' }}">
                                </div>
                            </address>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div>
                        <label for="observation">Observation</label>
                        <textarea type="text" class="form-control" id="observation" name="observation" placeholder="Observation" style="height: 100px">{{ $v_cheque->observation }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary" style="color: whitesmoke">Mettre à jour</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    @include('modals.info-cheque.nature-cheque-modal')
    @include('modals.info-cheque.situation-cheque-modal')
    @include('modals.info-cheque.travaux-devis-modal')

@endsection
