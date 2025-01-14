@extends(session('layout') ?? 'layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">

                            <div class="card p-3">
                                <div class="mb-2">
                                    <strong>Nom:</strong> {{ $dossier->nom }}
                                </div>
                                <div class="mb-2">
                                    <strong>Date de naissance:</strong> {{ $dossier->date_naissance }}
                                </div>
                                <div class="mb-2">
                                    <strong>Dossier:</strong> {{ $dossier->dossier }}
                                </div>
                                <div class="mb-2">
                                    <strong>Status:</strong> {{ $dossier->status }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="card-title card-title-dash mb-0">Liste des devis</h4>
                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div>
                                        <a href="{{ asset($dossier->dossier.'/nouveau-devis') }}">
                                        <button class="btn btn-primary btn-lg text-white mb-0">
                                            <i class="mdi mdi-file-document-outline me-2"></i> Nouveau devis
                                        </button>
                                        </a>
                                </div>
                            </div>
                            <div class="table-responsive  mt-1">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Dossier</th>
                                        <th>Date</th>
                                        <th>Montant</th>
                                        <th>Devis signé</th>
                                        <th>Praticien</th>
                                        <th>Observation</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($deviss as $devis)
                                        <tr style="background-color: {{ $devis->couleur }}">
                                            <td onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;"><strong>{{ $devis->dossier }}</strong></td>
                                            <td onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;"> {{ $devis->nom }}</td>
                                            <td onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">{{ $devis->getDate() }}</td>
                                            <td onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">{{ $devis->montant }}</td>
                                            <td onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                @if($devis->devis_signe == 'oui')
                                                    <label class="badge badge-info">Oui</label>
                                                @else
                                                    Non
                                                @endif
                                            </td>
                                            <td onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">{{ $devis->praticien }}</td>
                                            <td onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">{{ $devis->observation }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
