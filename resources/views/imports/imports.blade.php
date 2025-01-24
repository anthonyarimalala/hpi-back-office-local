@extends(session('layout') ?? 'layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Import de devis</h4>
                    @if(session('errors'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach(session('errors') as $error)
                                    <li>
                                        Erreur à la ligne {{ $error['line'] }} : {{ $error['errors'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p class="card-description">
                        Sélectionnez un fichier Excel (.xlsx) pour importer un devis.
                    </p>
                    <form action="{{ asset('devis/import') }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="devisFile">Fichier Excel</label>
                            <input type="file" class="form-control" id="devisFile" name="devisFile" accept=".xlsx">
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Importer</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
