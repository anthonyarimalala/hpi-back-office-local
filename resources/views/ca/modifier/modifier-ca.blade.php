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
            <h1 class="display-4">CA: Modification</h1>
        </div>
    </div>
    @php
        $cotation_restant = $v_ca_actes_reglement->cotation - $v_ca_actes_reglement->cotation_paye;
        $part_secu_restant = ($v_ca_actes_reglement->ro_part_secu ?? 0) - $v_ca_actes_reglement->ro_part_secu_paye;
        $part_mutuelle_restant = ($v_ca_actes_reglement->part_mutuelle ?? 0) - $v_ca_actes_reglement->part_mutuelle_paye;
        $rac_part_patient_restant = ($v_ca_actes_reglement->rac_part_patient ?? 0) - $v_ca_actes_reglement->rac_part_patient_paye;
        // echo '$cotation_restant = '.$cotation_restant.'<br>';
        // echo '$part_secu_restant = '.$part_secu_restant.'<br>';
        // echo '$part_mutuelle_restant = '.$part_mutuelle_restant.'<br>';
        // echo '$rac_part_patient_restant = '.$rac_part_patient_restant.'<br>';

        $couleur_cotation = "";
        $couleur_secu = "";
        $couleur_mutuelle = "";
        $couleur_rac = "";
        $couleur_dossier = "";

        if($cotation_restant < 0){$couleur_cotation = "orange"; $couleur_dossier = "orange"; }elseif($cotation_restant > 0) {$couleur_cotation = "red"; $couleur_dossier = "red";}
                                            if($part_secu_restant < 0){$couleur_secu = "orange"; $couleur_dossier = "orange";}elseif($part_secu_restant > 0) {$couleur_secu = "red"; $couleur_dossier = "red";}
                                            if($part_mutuelle_restant < 0){$couleur_mutuelle = "orange"; $couleur_dossier = "orange";}elseif($part_mutuelle_restant > 0) {$couleur_mutuelle = "red"; $couleur_dossier = "red";}
                                            if($rac_part_patient_restant < 0){$couleur_rac = "orange"; $couleur_dossier = "orange";}elseif($rac_part_patient_restant > 0) {$couleur_rac = "red"; $couleur_dossier = "red";}

    @endphp

    <form action="{{ asset('ca/modifier-2/'.$v_ca_actes_reglement->id_ca_actes_reglement) }}" method="POST">
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
                                    <td><input type="date" class="form-control" id="date_derniere_modif" name="date_derniere_modif" value="" placeholder="Date de modification" readonly></td>
                                    <td style="background-color: {{ $couleur_dossier }};"><input type="text" class="form-control" id="dossierr" name="dossierr" value="{{ $v_ca_actes_reglement->dossier }}" placeholder="Numéro de dossier" requiorange readonly></td>
                                    <td><input type="text" class="form-control" id="nom_patient" name="nom_patient" value="@if($v_ca_actes_reglement->nom) {{ $v_ca_actes_reglement->nom }} @else {{ old("nom_patient") }} @endif" placeholder="Nom du patient" readonly></td>
                                    <td>
                                        <select class="form-select" name="statut" id="statut" requiorange readonly>
                                            <option value="" disabled selected>Choix statut</option>
                                            @foreach($status as $st)
                                                <option value="{{ $st->status }}" @if($v_ca_actes_reglement->statut == $st->status) selected @endif>{{ $st->status }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" id="mutuelle" name="mutuelle" value="{{ $v_ca_actes_reglement->mutuelle }}" placeholder="Mutuelle" readonly></td>
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
                        <div class="d-sm-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="card-title mb-0" style="color: whitesmoke">ACTES</h4>
                            </div>
                            <div>
                                <a href="{{ asset('ca/'.$v_ca_actes_reglement->id.'/nouveau-acte') }}" class="text-primary">
                                    <i class="mdi mdi-plus mdi-24px">Nouveau</i>
                                </a>
                            </div>
                        </div>
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
                                        <select class="form-select" name="praticien" requiorange>
                                            <option value="" disabled>Choix praticien</option>
                                            @foreach($praticiens as $pra)
                                                <option value="{{ $pra->praticien }}" @if($v_ca_actes_reglement->praticien == $pra->praticien) selected @endif>{{ $pra->praticien }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" id="nom_acte" name="nom_acte" value="{{ $v_ca_actes_reglement->nom_acte }}" placeholder="Nom de l'acte"></td>
                                    <td style="background-color : {{ $couleur_cotation }}"><input type="number" min="0" step="0.01" class="form-control" id="cotation" name="cotation" value="{{ $v_ca_actes_reglement->cotation }}" placeholder="Cotation"></td>
                                    <td><input type="text" class="form-control" id="controle_securisation" name="controle_securisation" value="{{ $v_ca_actes_reglement->controle_securisation }}" placeholder="Contrôle sécurisation"></td>
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
                                    <td style="background-color : @if($couleur_secu != "") {{ $couleur_secu }} @else {{ $couleur_cotation }} @endif"><input type="number" min="0" step="0.01" class="form-control" id="ro_part_secu" name="ro_part_secu" value="{{ $v_ca_actes_reglement->ro_part_secu }}" placeholder="Part Sécu"></td>
                                    <td style="background-color : {{ $couleur_secu }}"><input type="number" min="0" step="0.01" class="form-control" id="ro_virement_recu" name="ro_virement_recu" value="{{ $v_ca_actes_reglement->ro_virement_recu }}" placeholder="Virement reçu"></td>
                                    <td style="background-color : {{ $couleur_secu }}"><input type="number" min="0" step="0.01" class="form-control" id="ro_indus_paye" name="ro_indus_paye" value="{{ $v_ca_actes_reglement->ro_indus_paye }}" placeholder="Indus payé"></td>
                                    <td style="background-color : {{ $couleur_secu }}"><input type="number" min="0" step="0.01" class="form-control" id="ro_indus_en_attente" name="ro_indus_en_attente" value="{{ $v_ca_actes_reglement->ro_indus_en_attente }}" placeholder="Indus en attente"></td>
                                    <td style="background-color : {{ $couleur_secu }}"><input type="number" min="0" step="0.01" class="form-control" id="ro_indus_irrecouvrable" name="ro_indus_irrecouvrable" value="{{ $v_ca_actes_reglement->ro_indus_irrecouvrable }}" placeholder="Indus irrecouvrable"></td>
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
                                    <td style="background-color: @if($couleur_mutuelle != "") {{ $couleur_mutuelle }} @else {{ $couleur_cotation }} @endif"><input type="number" min="0" step="0.01" class="form-control" id="part_mutuelle" name="part_mutuelle" value="{{ $v_ca_actes_reglement->part_mutuelle }}" placeholder="Part Mutuelle"></td>
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
                                    <td style="background-color: {{ $couleur_mutuelle }}"><input type="number" min="0" step="0.01" class="form-control" id="rcs_virement" name="rcs_virement" value="{{ $v_ca_actes_reglement->rcs_virement }}" placeholder="Montant virement"></td>
                                    <td style="background-color: {{ $couleur_mutuelle }}"><input type="number" min="0" step="0.01" class="form-control" id="rcs_especes" name="rcs_especes" value="{{ $v_ca_actes_reglement->rcs_especes }}" placeholder="Montant espèces"></td>
                                    <td style="background-color: {{ $couleur_mutuelle }}"><input type="number" min="0" step="0.01" class="form-control" id="rcs_cb" name="rcs_cb" value="{{ $v_ca_actes_reglement->rcs_cb }}" placeholder="Montant CB"></td>
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
                                    <td style="background-color: {{ $couleur_mutuelle }}"><input type="number" min="0" step="0.01" class="form-control" id="rcsd_cheque" name="rcsd_cheque" value="{{ $v_ca_actes_reglement->rcsd_cheque }}" placeholder="Montant chèque"></td>
                                    <td style="background-color: {{ $couleur_mutuelle }}"><input type="number" min="0" step="0.01" class="form-control" id="rcsd_especes" name="rcsd_especes" value="{{ $v_ca_actes_reglement->rcsd_especes }}" placeholder="Montant espèces"></td>
                                    <td style="background-color: {{ $couleur_mutuelle }}"><input type="number" min="0" step="0.01" class="form-control" id="rcsd_cb" name="rcsd_cb" value="{{ $v_ca_actes_reglement->rcsd_cb }}" placeholder="Montant CB"></td>
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
                                    <td style="background-color: @if($couleur_rac != "") {{ $couleur_rac }} @else {{ $couleur_cotation }} @endif"><input type="number" min="0" step="0.01" class="form-control" id="rac_part_patient" name="rac_part_patient" value="{{ $v_ca_actes_reglement->rac_part_patient }}" placeholder="Part patient"></td>
                                    <td style="background-color: {{ $couleur_rac }}"><input type="number" min="0" step="0.01" class="form-control" id="rac_cheque" name="rac_cheque" value="{{ $v_ca_actes_reglement->rac_cheque }}" placeholder="Montant chèque"></td>
                                    <td style="background-color: {{ $couleur_rac }}"><input type="number" min="0" step="0.01" class="form-control" id="rac_especes" name="rac_especes" value="{{ $v_ca_actes_reglement->rac_especes }}" placeholder="Montant espèces"></td>
                                    <td style="background-color: {{ $couleur_rac }}"><input type="number" min="0" step="0.01" class="form-control" id="rac_cb" name="rac_cb" value="{{ $v_ca_actes_reglement->rac_cb }}" placeholder="Montant CB"></td>
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
                                        <textarea class="form-control" id="commentaire" name="commentaire" style="height: 150px" placeholder="Ajoutez un commentaire..." >{{ $v_ca_actes_reglement->commentaire }}</textarea>
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
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header text-white" style="background: #F2CED5;">
                    <h4 class="card-title mb-0">Historique</h4>
                </div>
                <div class="card-body">
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
                                    <td>{{ $hist->dossier }}</td>
                                    <td>{!! nl2br($hist->action) !!}</td>
                                    <td>{{ $hist->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('jquery-3.7.1.min.js') }}"></script>

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



    <!-- Répète le même pattern pour les autres sections (RC soins avec DEVIS, RAC, Commentaires) -->

@endsection
