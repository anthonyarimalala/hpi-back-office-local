@extends('layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Grand titre -->
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <h1 class="display-4">Nouveau Devis</h1>
                    </div>
                </div>

                <form action="" method="POST" class="forms-sample">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card shadow-sm p-4">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="dossier">Dossier</label>
                                            <input type="text" class="form-control" id="dossier" name="doss" placeholder="Dossier" list="dossier-list">
                                            <datalist id="dossier-list">
                                            </datalist>
                                        </div>
                                        <div class="form-group">
                                            <label for="patient">Patient</label>
                                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Patient" value="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <label for="status">Status</label>
                                                    <select class="form-select" name="status" id="status">
                                                        <option value="" disabled selected>Choisissez un status</option>
                                                        @foreach($statuss as $s)
                                                            <option value="{{ $s->status }}">{{ $s->status }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#statusModal">
                                                        <i class="mdi mdi-cogs mr-2" style="font-size: 2rem;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            @error('status')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="mutuelle">Mutuelle</label>
                                            <input type="text" step="0.01" class="form-control" id="mutuelle" name="mutuelle" placeholder="Mutuelle" value="">
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
                                            <input type="number" step="0.01" min='1' class="form-control" id="montant" name="montant" placeholder="Montant" value="{{ old('montant') }}">
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
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <label for="praticien">Praticien</label>
                                                    <select id="praticien" name="praticien" class="form-select">
                                                        <option value="" disabled selected>Choisissez un praticien</option>
                                                        @foreach($praticiens as $praticien)
                                                            <option value="{{ $praticien->praticien }}" {{ old('praticien') == $praticien->praticien ? 'selected' : '' }}>
                                                                {{ $praticien->praticien }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#praticienModal">
                                                        <i class="mdi mdi-cogs mr-2" style="font-size: 2rem;"></i>
                                                    </a>
                                                </div>
                                            </div>
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
    <script src="{{ asset('jquery-3.7.1.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#dossier').on('input', function () {
                let query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: "{{ route('search.dossier') }}",
                        type: "GET",
                        data: { query: query },
                        success: function (data) {
                            let options = '';
                            data.forEach(function (dossier) {
                                options += `<option value="${dossier.dossier}">`;
                            });
                            $('#dossier-list').html(options);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dossier').on('input', function() {
                var dossier = $(this).val();

                if (dossier.length > 0) {
                    $.ajax({
                        url: "{{ route('get.patient.details') }}", // Route Laravel qui va chercher le nom
                        type: "GET",
                        data: { dossier: dossier },
                        success: function(response) {
                            if (response.success) {
                                if(response.nom_patient != null) $('#nom').val(response.nom_patient).css({"background-color": "#F2CED5", "transition": "background-color 5s ease"});
                                if(response.mutuelle != null) $('#mutuelle').val(response.mutuelle).css({"background-color": "#F2CED5", "transition": "background-color 5s ease"});
                                if(response.praticien != null) $('select[name="praticien"]').val(response.praticien).change().css({"background-color": "#F2CED5", "transition": "background-color 5s ease"});
                                if(response.statut != null) $('select[name="status"]').val(response.statut).change().css({"background-color": "#F2CED5", "transition": "background-color 5s ease"});

                                // Rétablir la couleur après 1 seconde
                                setTimeout(function() {
                                    $('#nom_patient, #mutuelle, select[name="praticien"], select[name="statut"]').css("background-color", "");
                                }, 5000);
                            } else {
                                $('#nom_patient').val('').css("background-color", "");
                                $('#mutuelle').val('').css("background-color", "");
                                $('select[name="praticien"]').val('').change().css("background-color", "");
                                $('select[name="statut"]').val('').change().css("background-color", "");
                            }
                        },
                        error: function() {
                            console.log("Erreur lors de la requête AJAX.");
                        }
                    });
                } else {
                    $('#nom_patient').val('').css("background-color", "");
                    $('#mutuelle').val('').css("background-color", "");
                    $('select[name="praticien"]').val('').change().css("background-color", "");
                    $('select[name="statut"]').val('').change().css("background-color", "");
                }
            });
        });

    </script>
    @include('modals.praticien-modal')

@endsection
