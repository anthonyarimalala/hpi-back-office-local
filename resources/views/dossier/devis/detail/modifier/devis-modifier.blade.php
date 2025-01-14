@extends(session('layout') ?? 'layouts.app')
@section('content')
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">Devis dossier: {{ $v_devis->dossier }}</h1>
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
            <div class="col-lg-8 d-flex flex-column">
                <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <h4 class="card-title">Devis</h4>
                                <div class="form-group">
                                    <label for="devis_etat">Etat</label>
                                    <select id="devis_etat" class="form-select" name="devis_etat" style="background-color: {{ $v_devis->couleur }}">
                                        @foreach($etat_devis as $ed)
                                            <option value="{{ $ed->etat }}" style="background-color: {{$ed->couleur}}" @if($ed->etat == $v_devis->etat) selected @endif>{{ $ed->etat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ $v_devis->date ? \Carbon\Carbon::parse($v_devis->date)->format('Y-m-d') : '' }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="devis_signe">Devis signé</label>
                                    <select class="form-select" id="devis_signe" name="devis_signe">
                                        <option value="oui" {{ $v_devis->devis_signe == 'oui' ? 'selected' : '' }}>Oui</option>
                                        <option value="non" {{ $v_devis->devis_signe == 'non' ? 'selected' : '' }}>Non</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="montant">Montant</label>
                                    <input type="number" step="0.01" class="form-control" id="montant" name="montant" value="{{ $v_devis->montant }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="praticien">Praticien</label>
                                    <input type="text" class="form-control" id="praticien" name="praticien" value="{{ $v_devis->praticien }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="observation">Observation</label>
                                    <textarea class="form-control" id="observation" name="observation" style="height: 50px" cols="50" placeholder="Observation">{{ $v_devis->observation }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accord PEC Section -->
                <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <h4 class="card-title">Retour mutuelle</h4>
                                <div class="form-group">
                                    <label for="envoi_pec">Envoi PEC</label>
                                    <input type="date" class="form-control" id="envoi_pec" name="date_envoi_pec" value="{{ $v_devis->date_envoi_pec ? \Carbon\Carbon::parse($v_devis->date_envoi_pec)->format('Y-m-d'):'' }}">
                                </div>
                                <div class="form-group">
                                    <label for="fin_validite_pec">Fin validité PEC</label>
                                    <input type="date" class="form-control" id="fin_validite_pec" name="date_fin_validite_pec" value="{{ $v_devis->date_fin_validite_pec ? \Carbon\Carbon::parse($v_devis->date_fin_validite_pec)->format('Y-m-d'):'' }}">
                                </div>
                                <div class="form-group">
                                    <label for="part_mutuelle">Part mutuelle</label>
                                    <input type="number" step="0.01" class="form-control" id="part_mutuelle" name="part_mutuelle" placeholder="Part Mutuelle" value="{{ $v_devis->part_mutuelle }}">
                                </div>
                                <div class="form-group">
                                    <label for="part_rac">Part RAC</label>
                                    <input type="number" step="0.01" class="form-control" id="part_rac" name="part_rac" placeholder="Part RAC" value="{{ $v_devis->part_rac }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paiements Section -->
                <div class="row flex-grow">
                    <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <h4 class="card-title">Règlements</h4>
                                <div class="form-group">
                                    <label for="paiement_cb_esp">Paiement par CB ou Esp</label>
                                    <input type="date" class="form-control" id="paiement_cb_esp" name="date_paiement_cb_ou_esp"
                                           value="{{ $v_devis->date_paiement_cb_ou_esp ? \Carbon\Carbon::parse($v_devis->date_paiement_cb_ou_esp)->format('Y-m-d') : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="depot_chq_pec">Depot CHQ PEC</label>
                                    <input type="date" class="form-control" id="depot_chq_pec" name="date_depot_chq_pec"
                                           value="{{ $v_devis->date_depot_chq_pec ? \Carbon\Carbon::parse($v_devis->date_depot_chq_pec)->format('Y-m-d') : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="depot_chq_mutuelle">Depot CHQ Part MUT</label>
                                    <input type="date" class="form-control" id="depot_chq_mutuelle" name="date_depot_chq_part_mut"
                                           value="{{ $v_devis->date_depot_chq_part_mut ? \Carbon\Carbon::parse($v_devis->date_depot_chq_part_mut)->format('Y-m-d') : '' }}">
                                </div>
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

            <!-- Appels et Mails Section -->
            <div class="col-lg-4 d-flex flex-column">
                <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <h4 class="card-title">Appels et mails</h4>

                                <div class="form-group">
                                    <label for="appel_1er">Date 1er appel</label>
                                    <input type="date" class="form-control" id="appel_1er" name="date_1er_appel"
                                           value="{{ $v_devis->date_1er_appel ? \Carbon\Carbon::parse($v_devis->date_1er_appel)->format('Y-m-d') : '' }}">
                                    <textarea class="form-control" name="note_1er_appel" id="appel_1er" placeholder="Note">{{ $v_devis->note_1er_appel }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="appel_2eme">Date 2ème appel</label>
                                    <input type="date" class="form-control" id="appel_2eme" name="date_2eme_appel"
                                           value="{{ $v_devis->date_2eme_appel ? \Carbon\Carbon::parse($v_devis->date_2eme_appel)->format('Y-m-d') : '' }}">
                                    <textarea class="form-control" name="note_2eme_appel" id="appel_2eme" placeholder="Note">{{ $v_devis->note_2eme_appel }}</textarea>

                                </div>

                                <div class="form-group">
                                    <label for="appel_3eme">Date 3ème appel</label>
                                    <input type="date" class="form-control" id="appel_3eme" name="date_3eme_appel"
                                           value="{{ $v_devis->date_3eme_appel ? \Carbon\Carbon::parse($v_devis->date_3eme_appel)->format('Y-m-d') : '' }}">
                                    <textarea class="form-control" name="note_3eme_appel" id="appel_3eme" placeholder="Note">{{ $v_devis->note_3eme_appel }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="date_email">Envoi mail</label>
                                    <input type="date" class="form-control" id="date_email" name="date_envoi_mail"
                                           value="{{ $v_devis->date_envoi_mail ? \Carbon\Carbon::parse($v_devis->date_envoi_mail)->format('Y-m-d') : '' }}">
                                </div>
                                <div class="form-group">
                                    <input class="form-check-input" type="checkbox" id="toutValider">
                                    <label class="form-check-label" for="toutValider">
                                        Tout marquer comme validé
                                    </label>
                                </div>
                            </div>

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
