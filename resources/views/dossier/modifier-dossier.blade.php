@extends('layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Grand titre -->
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <h1 class="display-4">Modifier dossier</h1>
                    </div>
                </div>

                <form action="{{ route('modifier.dossier') }}" method="POST" class="forms-sample">
                    @csrf
                    <input name="dossier" value="{{ $v_dossier->dossier }}" hidden>
                    <div class="row">
                        <!-- Premier formulaire -->
                        <div class="col-lg-6">
                            <div class="card shadow-sm p-4">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card-body">
                                        <h4 class="card-title">Patient</h4>

                                        <div class="form-group">
                                            <label for="nom">Nom</label>
                                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="{{ $v_dossier->nom }}">
                                            @error('nom')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="date_naissance">Date naissance</label>
                                            <input type="date" class="form-control" id="date_naissance" name="date_naissance" placeholder="Date de naissance" value="{{ $v_dossier->date_naissance }}" disabled>
                                            @error('date_naissance')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $v_dossier->email }}">
                                            @error('email')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Deuxième formulaire -->
                        <div class="col-lg-6">
                            <div class="card shadow-sm p-4">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card-body">
                                        <h4 class="card-title">Dossier</h4>
                                        <div class="form-group">
                                            <label for="dossier">Dossier</label>
                                            <input type="text" class="form-control" id="dossier" name="dossier" placeholder="Dossier" value="{{ $v_dossier->dossier }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <label for="status">Status</label>
                                                    <select class="form-select" id="status" name="status">
                                                        <option disabled selected>Choisissez le statut</option>
                                                        @foreach($statuss as $status)
                                                            <option
                                                                value="{{ $status->status }}" @if($status->status == $v_dossier->status) selected @endif>{{ $status->status }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#statusModal">
                                                        <i class="mdi mdi-cogs mr-2" style="font-size: 2rem;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="mutuellesContainer">
                                            <label for="mutuelle">Mutuelle </label>
                                            <input type="text" class="form-control" id="mutuelle" name="mutuelle" placeholder="Mutuelle" value="{{ $v_dossier->mutuelle }}">
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton Ajouter -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg" style="color: whitesmoke">Mettre à jour</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('modals.status-modal')

@endsection
