@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Erreurs lors des importations des CA</h4>
                    <div class="d-flex justify-content-center">
                        {{ $errors->links('pagination::bootstrap-4') }}
                    </div>
                    @foreach($errors as $err)
                        <blockquote class="blockquote blockquote-danger">
                            <header class="blockquote-header">Dossier: {{ $err->dossier }} [{{ \Carbon\Carbon::parse($err->date)->format('d/m/Y') }}]</header>
                            <header class="blockquote-header">{{ $err->categorie }}</header>
                            <p class="mb-0"><code>{{ $err->error_message }}</code><br> {!! nl2br($err->description) !!} </p>

                        </blockquote>
                    @endforeach
                    <div class="d-flex justify-content-center">
                        {{ $errors->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
