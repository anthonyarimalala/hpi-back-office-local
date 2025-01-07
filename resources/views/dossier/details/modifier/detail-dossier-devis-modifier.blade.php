@extends(session('layout') ?? 'layouts.app')
@section('content')
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">Devis dossier: {{ $v_devis->dossier }}</h1>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-8 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <h4 class="card-title">Devis</h4>
                            <form class="forms-sample">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" id="date" placeholder="Date">
                                </div>
                                <div class="form-group">
                                    <label>
                                        <select class="form-select">
                                            <option value="oui">Signé</option>
                                            <option value="non">Non signé</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="montant">Montant</label>
                                    <input type="number" step="0.01" class="form-control" id="montant" placeholder="Montant">
                                </div>
                                <div class="form-group">
                                    <label for="praticien">Praticien</label>
                                    <input type="text" class="form-control" id="praticien" placeholder="Praticient">
                                </div>
                                <div class="form-group">
                                    <label for="observation">Observation</label>
                                    <textarea class="form-control" id="observation" placeholder="Observation" style="height: 50px" cols="50"></textarea>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Accord PEC</h4>
                                    <p class="card-subtitle card-subtitle-dash">Charge d'acceuil</p>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Envoi PEC</th>
                                        <th>Fin validité PEC</th>
                                        <th>Part mutuelle</th>
                                        <th>Part RAC</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="py-1">
                                            <div class="form-group">
                                                <label for="envoi_pec"></label>
                                                <input type="date" class="form-control" id="envoi_pec" placeholder="Envoi Pec">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="fin_validite_pec"></label>
                                                <input type="date" class="form-control" id="fin_validite_pec" placeholder="fin_validite_pec">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="part_mutuelle"></label>
                                                <input type="number" step="0.01" class="form-control" id="part_mutuelle" placeholder="Mutuelle">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="part_rac"></label>
                                                <input type="number" step="0.01" class="form-control" id="part_rac" placeholder="RAC">
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row flex-grow">
                <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body card-rounded">
                            <h4 class="card-title  card-title-dash">Règlements</h4>
                            <div class="list align-items-center border-bottom py-2">
                                <div class="form-group">
                                    <label for="fin_validite_pec">Paiement par CB ou Esp</label>
                                    <input type="date" class="form-control" id="fin_validite_pec" placeholder="fin_validite_pec">
                                </div>
                            </div>
                            <div class="list align-items-center border-bottom py-2">
                                <div class="form-group">
                                    <label for="fin_validite_pec">Depot CHQ PEC</label>
                                    <input type="date" class="form-control" id="fin_validite_pec" placeholder="fin_validite_pec">
                                </div>
                            </div>
                            <div class="list align-items-center border-bottom py-2">
                                <div class="form-group">
                                    <label for="fin_validite_pec">Depot CHQ Part MUT</label>
                                    <input type="date" class="form-control" id="fin_validite_pec" placeholder="fin_validite_pec">
                                </div>
                            </div>
                            <div class="list align-items-center border-bottom py-2">
                                <div class="form-group">
                                    <label for="fin_validite_pec">Depot CHQ RAC</label>
                                    <input type="date" class="form-control" id="fin_validite_pec" placeholder="fin_validite_pec">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex flex-column">

            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <h4 class="card-title">Appels et mail</h4>
                                <div class="form-group">
                                    <label for="1er_appel">1er appel</label>
                                    <input type="date" class="form-control" id="1er_appel" name="date_1er_appel" placeholder="Username">
                                    <textarea class="form-control" id="1er_appel" name="note_1er_appel" placeholder="Note"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="1er_appel">2ème appel</label>
                                    <input type="date" class="form-control" id="1er_appel" name="date_2eme_appel" placeholder="Username">
                                    <textarea class="form-control" id="1er_appel" name="note_2eme_appel" placeholder="Note"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="1er_appel">3ème appel</label>
                                    <input type="date" class="form-control" id="1er_appel" name="date_3eme_appel" placeholder="Username">
                                    <textarea class="form-control" id="1er_appel" name="note_3eme_appel" placeholder="Note"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="1er_appel">Envoie mail</label>
                                    <input type="date" class="form-control" id="1er_appel" name="date_email" placeholder="Username">
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
