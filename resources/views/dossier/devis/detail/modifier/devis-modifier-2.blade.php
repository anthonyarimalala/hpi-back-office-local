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
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#devis" role="tab" aria-controls="overview" aria-selected="true">Devis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" href="{{ asset($v_devis->dossier.'/prothese/'.$v_devis->id_devis.'/detail') }}" role="tab" aria-selected="false">Prothèse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" href="{{ asset($v_devis->dossier.'/cheque/'.$v_devis->id_devis.'/detail') }}" role="tab" aria-selected="false">Chèque</a>
            </li>
        </ul>
    </div>
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <h1 class="display-4 me-3">Modifier devis dossier: {{ $v_devis->dossier }}</h1>
        </div>
    </div>
    @if(session('success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    <form action="{{ asset('modifier-devis') }}" method="POST">
    @csrf
    <label>
        <input type="text" name="id_devis" value="{{ $v_devis->id_devis }}" hidden>
    </label>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header text-white">
                    <h4 class="card-title mb-0" style="color: whitesmoke">Info Devis</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="devis_etat"></label>
                            <select id="devis_etat" class="form-select" name="id_devis_etat" style="background-color: {{ $v_devis->couleur }}">
                                @foreach($etat_devis as $ed)
                                    <option value="{{ $ed->id }}" style="background-color: {{$ed->couleur}}" @if($ed->etat == $v_devis->etat) selected @endif>{{ $ed->etat }}</option>
                                @endforeach
                            </select>
                            <p class="card-subtitle card-subtitle-dash"> Dossier: {{ $v_devis->dossier }}</p>
                            <p class="card-subtitle card-subtitle-dash"> Nom: {{ $v_devis->nom }}</p>
                            <p class="card-subtitle card-subtitle-dash"> Status: {{ $v_devis->status }}</p>
                            <p class="card-subtitle card-subtitle-dash"> Mutuelle: {{ $v_devis->mutuelle }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-dark">Date: @if($v_devis->date != null) {{ \Carbon\Carbon::parse($v_devis->date)->translatedFormat('d F Y') }} @endif</p>
                            <p class="text-dark">Montant: {{ number_format($v_devis->montant, 2, ',', ' ') }} Euro </p>
                            <div class="form-group">
                                <label for="devis_signe">Devis signé</label>
                                <select class="form-select" id="devis_signe" name="devis_signe">
                                    <option value="oui" {{ $v_devis->devis_signe == 'oui' ? 'selected' : '' }}>Oui</option>
                                    <option value="non" {{ $v_devis->devis_signe == 'non' ? 'selected' : '' }}>Non</option>
                                </select>
                            </div>
                            <p class="text-dark">Praticien: {{ $v_devis->getPraticien() }} </p>
                            <div class="form-group">
                                <label for="observation">Observation</label>
                                <textarea class="form-control" id="observation" name="observation" style="height: 50px" cols="50" placeholder="Observation">{{ $v_devis->devis_observation }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-white">
                    <h4 class="card-title mb-0" style="color: whitesmoke">Retour mutuelle</h4>
                </div>
                <div class="card-body">
                    <div class="list align-items-center border-bottom py-2">
                        <div class="form-group">
                            <label for="envoi_pec">Envoi PEC</label>
                            <input type="date" class="form-control" id="envoi_pec" name="date_envoi_pec" value="{{ $v_devis->date_envoi_pec ? \Carbon\Carbon::parse($v_devis->date_envoi_pec)->format('Y-m-d'):'' }}">
                        </div>
                    </div>
                    <div class="list align-items-center border-bottom py-2">
                        <div class="form-group">
                            <label for="fin_validite_pec">Fin validité PEC</label>
                            <input type="date" class="form-control" id="fin_validite_pec" name="date_fin_validite_pec" value="{{ $v_devis->date_fin_validite_pec ? \Carbon\Carbon::parse($v_devis->date_fin_validite_pec)->format('Y-m-d'):'' }}">
                        </div>
                    </div>
                    <div class="list align-items-center border-bottom py-2">
                        <div class="form-group">
                            <label for="part_mutuelle">Part mutuelle</label>
                            <input type="number" step="0.01" class="form-control" id="part_mutuelle" name="part_mutuelle" placeholder="Part Mutuelle" value="{{ $v_devis->part_mutuelle }}">
                        </div>
                    </div>
                    <div class="list align-items-center border-bottom py-2">
                        <div class="form-group">
                            <label for="part_rac">Part RAC</label>
                            <input type="number" step="0.01" class="form-control" id="part_rac" name="part_rac" placeholder="Part RAC" value="{{ $v_devis->part_rac }}">
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-white">
                    <h4 class="card-title mb-0" style="color: whitesmoke">Règlements</h4>
                </div>
                <div class="card-body">
                    <div class="container">
                        <!-- Date paiement par CB ou Esp -->
                        <div class="row align-items-center border-bottom py-2">
                            <div class="form-group">
                                <label for="paiement_cb_esp">Paiement par CB ou Esp</label>
                                <input type="date" class="form-control" id="paiement_cb_esp" name="date_paiement_cb_ou_esp"
                                       value="{{ $v_devis->date_paiement_cb_ou_esp ? \Carbon\Carbon::parse($v_devis->date_paiement_cb_ou_esp)->format('Y-m-d') : '' }}">
                            </div>
                        </div>

                        <!-- Date depot CHQ PEC -->
                        <div class="row align-items-center border-bottom py-2">
                            <div class="form-group">
                                <label for="depot_chq_pec">Depot CHQ PEC</label>
                                <input type="date" class="form-control" id="depot_chq_pec" name="date_depot_chq_pec"
                                       value="{{ $v_devis->date_depot_chq_pec ? \Carbon\Carbon::parse($v_devis->date_depot_chq_pec)->format('Y-m-d') : '' }}">
                            </div>
                        </div>

                        <!-- Date depot CHQ Part MUT -->
                        <div class="row align-items-center border-bottom py-2">
                            <div class="form-group">
                                <label for="depot_chq_mutuelle">Depot CHQ Part MUT</label>
                                <input type="date" class="form-control" id="depot_chq_mutuelle" name="date_depot_chq_part_mut"
                                       value="{{ $v_devis->date_depot_chq_part_mut ? \Carbon\Carbon::parse($v_devis->date_depot_chq_part_mut)->format('Y-m-d') : '' }}">
                            </div>
                        </div>

                        <!-- Date depot CHQ RAC -->
                        <div class="row align-items-center py-2">
                            <div class="form-group">
                                <label for="depot_chq_rac">Depot CHQ RAC</label>
                                <input type="date" class="form-control" id="depot_chq_rac" name="date_depot_chq_rac"
                                       value="{{ $v_devis->date_depot_chq_rac ? \Carbon\Carbon::parse($v_devis->date_depot_chq_rac)->format('Y-m-d') : '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-white">
                    <h4 class="card-title mb-0" style="color: whitesmoke">Appels & Mails</h4>
                </div>
                <div class="card-body">
                    <div class="list-wrapper">
                        <ul class="todo-list todo-list-rounded">
                            <li class="d-block">
                                <div class="form-check w-100">
                                    <label for="appel_1er">Date 1er appel</label>
                                    <input type="date" class="form-control" id="appel_1er" name="date_1er_appel"
                                           value="{{ $v_devis->date_1er_appel ? \Carbon\Carbon::parse($v_devis->date_1er_appel)->format('Y-m-d') : '' }}">
                                    <textarea class="form-control" name="note_1er_appel" id="appel_1er" placeholder="Note">{{ $v_devis->note_1er_appel }}</textarea>
                                </div>
                            </li>
                            <li class="d-block">
                                <div class="form-check w-100">
                                    <label for="appel_2eme">Date 2ème appel</label>
                                    <input type="date" class="form-control" id="appel_2eme" name="date_2eme_appel"
                                           value="{{ $v_devis->date_2eme_appel ? \Carbon\Carbon::parse($v_devis->date_2eme_appel)->format('Y-m-d') : '' }}">
                                    <textarea class="form-control" name="note_2eme_appel" id="appel_2eme" placeholder="Note">{{ $v_devis->note_2eme_appel }}</textarea>
                                </div>
                            </li>
                            <li>
                                <div class="form-check w-100">
                                    <label for="appel_3eme">Date 3ème appel</label>
                                    <input type="date" class="form-control" id="appel_3eme" name="date_3eme_appel"
                                           value="{{ $v_devis->date_3eme_appel ? \Carbon\Carbon::parse($v_devis->date_3eme_appel)->format('Y-m-d') : '' }}">
                                    <textarea class="form-control" name="note_3eme_appel" id="appel_3eme" placeholder="Note">{{ $v_devis->note_3eme_appel }}</textarea>

                                </div>
                            </li>
                            <li class="border-bottom-0">
                                <div class="form-check w-100">
                                    <label for="date_email">Envoi mail</label>
                                    <a href="#dateModal" data-bs-toggle="modal"
                                       data-bs-target="#dateModal">Envoyer un email</a>
                                    <label for="date_email">Envoyé?</label><input type="checkbox" id="emailCheckbox" name="email_sent" value="1" @if($v_devis->email_sent == 1) checked @endif>
                                    <input type="date" class="form-control" id="date_email" name="date_envoi_mail"
                                           value="{{ $v_devis->date_envoi_mail ? \Carbon\Carbon::parse($v_devis->date_envoi_mail)->format('Y-m-d') : '' }}">


                                </div>
                            </li>
                        </ul>
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
    <div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateModalLabel">Envoyer un Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="exportForm" action="{{ asset('envoi-mail-2') }}" method="GET">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email du destinataire</label>
                                    <input hidden name="id_devis" value="{{ $v_devis->id_devis }}">
                                    <input type="email" id="email" class="form-control" placeholder="Email du destinataire" value="{{ $v_devis->email }}" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Objet</label>
                                    <input type="text" id="subject" class="form-control" placeholder="Objet" name="objet" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Votre message</label>
                                    <textarea id="message" style="height: 200px" class="form-control" placeholder="Votre message" rows="4" name="message" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Envoyer</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const partMutuelleInput = document.getElementById("part_mutuelle");
            const partRacInput = document.getElementById("part_rac");
            const montantTotal = parseFloat("{{ $v_devis->montant }}") || 0;
            const partRacInitial = parseFloat("{{ $v_devis->part_rac }}");

            if (!partRacInitial) { // Vérifie si part_rac est nul ou 0
                partMutuelleInput.addEventListener("input", function() {
                    let partMutuelle = parseFloat(partMutuelleInput.value) || 0;
                    let partRac = montantTotal - partMutuelle;
                    partRacInput.value = partRac.toFixed(2);
                });
            }
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectElement = document.getElementById('devis_etat');

            selectElement.addEventListener('change', function () {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const color = selectedOption.style.backgroundColor;
                selectElement.style.backgroundColor = color;
            });
        });
    </script>


@endsection
