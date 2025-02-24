@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Liste des Nature de Chèque</h4>
                                </div>
                            </div>
                            <div class="mt-1">
                                <ul class="list-group">
                                    @foreach($datas as $dt)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6>{{ $dt->nature_cheque }}</h6>
                                            </div>
                                            <div class="d-flex">
                                                <!-- Bouton Supprimer -->
                                                <form action="" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce statut ?');">
                                                    @csrf
                                                    <input id="status" type="text" name="nature_cheque" value="{{ $dt->id }}" hidden>
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
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
                                    <h4 class="card-title card-title-dash">Nouveau nature chèque</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Formulaire Ajouter un nouveau statut -->
                        <form action="" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nature_cheque" class="form-label">Nature chèque</label>
                                <input type="text" class="form-control" id="nature_cheque" name="nature_cheque" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
