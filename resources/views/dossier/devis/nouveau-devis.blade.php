@extends(session('layout') ?? 'layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
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
                    <div class="mb-2">
                        <strong>Mutuelle:</strong> {{ $dossier->mutuelle }}
                    </div>
                </div>
                <!-- Grand titre -->
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <h1 class="display-4">Nouveau Devis</h1>
                    </div>
                </div>

                <form action="{{ asset($dossier->dossier.'/nouveau-devis') }}" method="POST" class="forms-sample">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card shadow-sm p-4">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="dossier">Dossier</label>
                                            <input type="text" class="form-control" id="dossier" name="dossier" placeholder="Dossier" value="{{ $dossier->dossier }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-select" name="status" id="status">
                                                @foreach($statuss as $s)
                                                    <option value="{{ $s->status }}" @if($dossier->status == $s->status) selected @endif>{{ $s->status }}</option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="mutuelle">Mutuelle</label>
                                            <input type="text" step="0.01" class="form-control" id="mutuelle" name="mutuelle" placeholder="Mutuelle" value="{{ $dossier->mutuelle }}">
                                            @error('mutuelle')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="date" class="form-control" id="date" name="date" placeholder="Date" value="{{ old('date') }}">
                                            @error('date')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="montant">Montant</label>
                                            <input type="number" step="0.01" class="form-control" id="montant" name="montant" placeholder="Montant" value="{{ old('montant') }}">
                                            @error('montant')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Premier formulaire -->
                        <div class="col-lg-6">
                            <div class="card shadow-sm p-4">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="devis_signe">Devis signé?</label>
                                            <select id="devis_signe" name="devis_signe" class="form-select">
                                                <option value="non" {{ old('devis_signe') == 'non' ? 'selected' : '' }}>NON</option>
                                                <option value="oui" {{ old('devis_signe') == 'oui' ? 'selected' : '' }}>OUI</option>
                                            </select>
                                            @error('devis_signe')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="praticien">Praticien</label>
                                            <select id="praticien" name="praticien" class="form-select">
                                                @foreach($praticiens as $praticien)
                                                    <option value="{{ $praticien->praticien }}" {{ old('praticien') == $praticien->praticien ? 'selected' : '' }}>
                                                        {{ $praticien->praticien }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('praticien')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="observation">Observation</label>
                                            <textarea class="form-control" id="observation" name="observation" placeholder="Observation" style="height: 100px">{{ old('observation') }}</textarea>
                                            @error('observation')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Deuxième formulaire -->

                    <!-- Bouton Ajouter -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg" style="color: whitesmoke;">Ajouter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
