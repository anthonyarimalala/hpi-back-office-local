@extends(session('layout') ?? 'layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Liste des statuts</h4>
                                </div>
                            </div>
                            <div class="mt-1">
                                <ul class="list-group">
                                    @foreach($dossier_statuss as $status)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6>{{ $status->status }}</h6>
                                                <p>{{ $status->signification }}</p>
                                            </div>
                                            <div class="d-flex">
                                                <!-- Bouton Supprimer -->
                                                <form action="{{ asset('delete-dossier-status') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce statut ?');">
                                                    @csrf
                                                    <input id="status" type="text" name="status" value="{{ $status->status }}" hidden>
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
                                    <h4 class="card-title card-title-dash">Nouveau statut</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Formulaire Ajouter un nouveau statut -->
                        <form action="{{ asset('save-dossier-status') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status" required>
                            </div>
                            <div class="mb-3">
                                <label for="signification" class="form-label">Signification</label>
                                <input type="text" class="form-control" id="signification" name="signification">
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter le statut</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
