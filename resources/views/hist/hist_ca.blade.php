@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Historique Ca</h4>
                    <div class="d-flex justify-content-center">
                        {{ $hists->links('pagination::bootstrap-4') }}
                    </div>
                    <div class="table-responsive">
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
                                    <td>{{ $hist->nom }}</td>
                                    <td onclick="window.location.href='{{ asset('ca/'.$hist->id_ca_actes_reglement.'/'.$hist->dossier.'/modifier') }}';"
                                        style="cursor: pointer;"
                                        onmouseover="this.style.backgroundColor='#f0f0f0';"
                                        onmouseout="this.style.backgroundColor='';">{{ $hist->dossier }}</td>
                                    <td>{!! nl2br($hist->action) !!}</td>
                                    <td>{{ \Carbon\Carbon::parse($hist->created_at)->format('d-m-Y H:m') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $hists->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
