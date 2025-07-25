@extends('layouts.app')

@section('content')
    <style>
        .card-header {
            background: linear-gradient(
                -135deg,
                transparent 60%,
                #575756 60%,
                #575756 100%);
        }



    </style>
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">CA: Nouveau</h1>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger text-center">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ asset('ca/nouveau-2') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white">
                        <h4 class="card-title mb-0" style="color: whitesmoke">INFOS PATIENTS</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th>Date de dernière modification</th>
                                    <th>N° dossier</th>
                                    <th>Nom du patient</th>
                                    <th>Statut</th>
                                    <th>Mutuelle</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="date" class="form-control" id="date_derniere_modif" name="date_derniere_modif" placeholder="Date de modification" value="{{ old('date_derniere_modif') }}"></td>
                                    <td>
                                        <input type="text" class="form-control" id="dossiers" name="dossiers" placeholder="Numéro de dossier" required list="dossier-list">
                                        <datalist id="dossier-list">
                                        </datalist>
                                    </td>

                                    <td><input type="text" class="form-control" id="nom_patient" name="nom_patient" placeholder="Nom du patient" readonly ></td>
                                    <td>
                                        <select class="form-select" name="statut" required>
                                            <option value="" disabled selected>Choix statut</option>
                                            @foreach($status as $st)
                                                <option value="{{ $st->status }}" @if(old('statut') == $st->status) selected @endif>{{ $st->status }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" id="mutuelle" name="mutuelle" placeholder="Mutuelle"></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white">
                        <h4 class="card-title mb-0" style="color: whitesmoke">ACTES</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th>Praticien</th>
                                    <th>Nom de l'acte</th>
                                    <th>Cotation</th>
                                    <th>Contrôle sécurisation</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <select class="form-select" name="praticien" required>
                                                    <option value="" disabled selected>Choix praticien</option>
                                                    @foreach($praticiens as $pra)
                                                        <option value="{{ $pra->praticien }}" @if(old('praticien')==$pra->praticien) selected @endif>{{ $pra->praticien }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#praticienModal">
                                                    <i class="mdi mdi-cogs mr-2" style="font-size: 1.5rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control" id="nom_acte" name="nom_acte" placeholder="Nom de l'acte" required></td>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="cotation" name="cotation" placeholder="Cotation"></td>
                                    <td><input type="text" class="form-control" id="controle_securisation" name="controle_securisation" placeholder="Contrôle sécurisation"></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white">
                        <h4 class="card-title mb-0" style="color: whitesmoke">RO</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th>Part Sécu</th>
                                    <th>Virement reçu</th>
                                    <th>Indus payé</th>
                                    <th>Indus en attente</th>
                                    <th>Indus irrecouvrable</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="ro_part_secu" name="ro_part_secu" placeholder="Part Sécu"></td>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="ro_virement_recu" name="ro_virement_recu" placeholder="Virement reçu"></td>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="ro_indus_paye" name="ro_indus_paye" placeholder="Indus payé"></td>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="ro_indus_en_attente" name="ro_indus_en_attente" placeholder="Indus en attente"></td>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="ro_indus_irrecouvrable" name="ro_indus_irrecouvrable" placeholder="Indus irrecouvrable"></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="card-title mb-0" style="color: whitesmoke">Mutuelle</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th>Part Mutuelle</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="part_mutuelle" name="part_mutuelle" placeholder="Part Mutuelle"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header text-white">
                        <h4 class="card-title mb-0" style="color: whitesmoke">RC SOINS</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th>Virement</th>
                                    <th>Espèces</th>
                                    <th>CB</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="rcs_virement" name="rcs_virement" placeholder="Montant virement"></td>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="rcs_especes" name="rcs_especes" placeholder="Montant espèces"></td>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="rcs_cb" name="rcs_cb" placeholder="Montant CB"></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white">
                        <h4 class="card-title mb-0" style="color: whitesmoke">RC soins avec DEVIS</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th>Chèque</th>
                                    <th>Espèces</th>
                                    <th>CB</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="rcsd_cheque" name="rcsd_cheque" placeholder="Montant chèque"></td>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="rcsd_especes" name="rcsd_especes" placeholder="Montant espèces"></td>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="rcsd_cb" name="rcsd_cb" placeholder="Montant CB"></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white">
                        <h4 class="card-title mb-0" style="color: whitesmoke">RAC</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th>Part patient</th>
                                    <th>Chèque</th>
                                    <th>Espèces</th>
                                    <th>CB</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="rac_part_patient" name="rac_part_patient" placeholder="Part patient"></td>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="rac_cheque" name="rac_cheque" placeholder="Montant chèque"></td>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="rac_especes" name="rac_especes" placeholder="Montant espèces"></td>
                                    <td><input type="number" min="0" step="0.01" class="form-control" id="rac_cb" name="rac_cb" placeholder="Montant CB"></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-white">
                        <h4 class="card-title mb-0" style="color: whitesmoke">Commentaire</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th>Commentaire</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <textarea class="form-control" id="commentaire" name="commentaire" style="height: 150px" placeholder="Ajoutez un commentaire..."></textarea>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center mt-4">
                <button type="submit" class="btn btn-primary" style="color: whitesmoke">Mettre à jour</button>
            </div>
        </div>
    </form>
    <script src="{{ asset('jquery-3.7.1.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#dossiers').on('input', function () {
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
            $('#dossiers').on('input', function() {
                var dossier = $(this).val();

                if (dossier.length > 0) {
                    $.ajax({
                        url: "{{ route('get.patient.details') }}", // Route Laravel qui va chercher le nom
                        type: "GET",
                        data: { dossier: dossier },
                        success: function(response) {
                            if (response.success) {
                                if(response.nom_patient != null) $('#nom_patient').val(response.nom_patient).css({"background-color": "#F2CED5", "transition": "background-color 5s ease"});
                                if(response.mutuelle != null) $('#mutuelle').val(response.mutuelle).css({"background-color": "#F2CED5", "transition": "background-color 5s ease"});
                                if(response.praticien != null) $('select[name="praticien"]').val(response.praticien).change().css({"background-color": "#F2CED5", "transition": "background-color 5s ease"});
                                if(response.statut != null) $('select[name="statut"]').val(response.statut).change().css({"background-color": "#F2CED5", "transition": "background-color 5s ease"});

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

    <!-- Répète le même pattern pour les autres sections (RC soins avec DEVIS, RAC, Commentaires) -->

@endsection
