@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Historique Chèques</h4>
                    <div class="table-responsive">
                        <div class="d-flex justify-content-center">
                            {{ $hists->links('pagination::bootstrap-4') }}
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Dossier</th>
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($hists as $hist)
                                <tr>
                                    <td>{{ $hist->prenom }} {{ $hist->nom }}</td>
                                    <td>{{ $hist->dossier }}</td>
                                    <td>{!! nl2br($hist->action) !!}</td>
                                    <td>{{ $hist->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $hists->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
