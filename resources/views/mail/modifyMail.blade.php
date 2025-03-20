@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-6 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <h4 class="card-title card-title-dash mb-0">Changer l'email</h4>
                            <form action="{{ asset('modify/mail') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="mail_name" class="form-label">Nom de l'email</label>
                                    <input type="text" name="mail_name" id="mail_name" class="form-control" placeholder="Nom de l'email" value="{{ \Illuminate\Support\Facades\Auth::user()->mail_name }}" required>
                                    @error('mail_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="mail" class="form-label">Email</label>
                                    <input type="text" name="mail" id="mail" class="form-control" placeholder="Email" value="{{ \Illuminate\Support\Facades\Auth::user()->mail_sender }}" required>
                                    @error('mail')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="mail_password" class="form-label">Mot de passe d'application</label>
                                    <input type="password" name="mail_password" id="mail_password" class="form-control" placeholder="Mot de passe" required>
                                    @error('nom')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
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
