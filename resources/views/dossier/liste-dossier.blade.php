@extends(session('layout') ?? 'layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Liste des dossiers</h4>
                                </div>

                            </div>
                            <div class="table-responsive  mt-1">
                                <div class="d-flex justify-content-center">
                                    {{ $v_dossiers->links('pagination::bootstrap-4') }}
                                </div>
                                <table class="table table-hover select-table">
                                    <thead>
                                    <tr>
                                        <th>Dernière modif</th>
                                        <th>Dossier</th>
                                        <th>Patient</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($v_dossiers as $dossier)
                                        <tr>
                                            <td onclick="window.location.href='{{ $dossier->dossier }}/details';" style="cursor:pointer;">
                                                {{ \Carbon\Carbon::parse($dossier->updated_at)->translatedFormat('d F Y') }}
                                            </td>
                                            <td onclick="window.location.href='{{ $dossier->dossier }}/details';" style="cursor:pointer;">
                                                {{ $dossier->dossier }}
                                            </td>
                                            <td onclick="window.location.href='{{ $dossier->dossier }}/details';" style="cursor:pointer;">
                                                <div class="d-flex ">
                                                    <div>
                                                        <h6>{{ $dossier->nom }}</h6>
                                                        <p>{{ \Carbon\Carbon::parse($dossier->date_naissance)->translatedFormat('d F Y') }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td onclick="window.location.href='{{ $dossier->dossier }}/details';" style="cursor:pointer;">
                                                <div class="badge badge-opacity-warning">{{ $dossier->status }}</div>
                                            </td>
                                            <td>
                                                <a href="{{ asset("modifier-dossier/".$dossier->dossier) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $v_dossiers->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
