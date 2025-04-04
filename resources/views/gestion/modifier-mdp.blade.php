@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-6 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <h4 class="card-title card-title-dash mb-0">Modifier le mot de passe</h4>
                            <div class="mb-3">
                                <label for="prenom" class="form-label"><strong>Prénom: </strong></label>
                                <span id="prenom">{{ $m_user->prenom }}</span>
                            </div>

                            <div class="mb-3">
                                <label for="nom" class="form-label"><strong>Nom: </strong></label>
                                <span id="nom">{{ $m_user->nom }}</span>
                            </div>
                            <form action="" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="old_password" class="form-label">Ancien mot de passe</label>
                                    <input type="password" name="old_password" id="old_password" class="form-control" required>
                                    @error('old_password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmation de Mot De Passe</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Modifier</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
