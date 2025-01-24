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
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                    <!-- Section INFO DEVIS -->
                                    <tr>
                                        <th class="infoCheques" colspan="8" style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">INFO DEVIS</th>
                                        <th class="infoAccordPec" colspan="4" style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">INFO ACCORD PEC</th>
                                        <th class="appelsMail" colspan="7" style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">APPELS & MAIL</th>
                                        <th class="infoEmpreinte" colspan="6" style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">INFO D'EMPREINTE</th>
                                        <th class="retourLabo" colspan="3" style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">RETOUR LABO</th>
                                        <th class="pose" colspan="2" style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">POSE</th>
                                        <th class="travauxCloture" colspan="4" style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">TRAVAUX CLOTURE</th>
                                        <th class="infoCheques" colspan="9" style="background-color: #f8f9fa; text-align: center;">INFO CHEQUES</th>
                                    </tr>
                                    <tr>
                                        <!-- INFO DEVIS -->
                                        <!-- triTableau(tableId, columnIndex, isText = true, isNumber = false, isDate = false) -->
                                        <!-- 0 -->
                                        <th onclick="sortTableByString('myTable', 0)" class="infoCheques">Dossier<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 1 -->
                                        <th onclick="sortTableByString('myTable', 1)" class="infoCheques">Patient<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 2 -->
                                        <th onclick="sortTableByString('myTable', 2)" class="infoCheques">Status<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 3 -->
                                        <th onclick="sortTableByString('myTable', 3)" class="infoCheques">Mutuelle<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 4 -->
                                        <th onclick="sortTableByDate('myTable', 4)" class="infoCheques">Date<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 5 -->
                                        <th onclick="sortTableByNumber('myTable', 5)" class="infoCheques">Montant<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 6 -->
                                        <th onclick="sortTableByString('myTable', 6)" class="infoCheques">Devis signé<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 7 -->
                                        <th onclick="sortTableByString('myTable', 7)" style="border-right: 2px solid #000;" class="infoCheques">Praticien<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- INFO ACCORD PEC -->
                                        <!-- 8 -->
                                        <th onclick="sortTableByDate('myTable', 8)" class="infoAccordPec">Date envoie PEC<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 9 -->
                                        <th onclick="sortTableByDate('myTable', 9)" class="infoAccordPec">Date fin validité PEC<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 10 -->
                                        <th onclick="sortTableByNumber('myTable', 10)" class="infoAccordPec">Part mutuelle<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 11 -->
                                        <th onclick="sortTableByNumber('myTable', 11)" style="border-right: 2px solid #000;" class="infoAccordPec">Part RAC<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- APPELS & MAIL -->
                                        <!-- 12 -->
                                        <th onclick="sortTableByDate('myTable', 12)" class="appelsMail">Date 1er appel<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 13 -->
                                        <th class="appelsMail">Note 1er appel</th>
                                        <!-- 14 -->
                                        <th onclick="sortTableByDate('myTable', 14)" class="appelsMail">Date 2ème appel<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 15 -->
                                        <th class="appelsMail">Note 2ème appel</th>
                                        <!-- 16 -->
                                        <th onclick="sortTableByDate('myTable', 16)" class="appelsMail">Date 3ème appel<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 17 -->
                                        <th class="appelsMail">Note 3ème appel</th>
                                        <!-- 18 -->
                                        <th onclick="sortTableByDate('myTable', 18)" style="border-right: 2px solid #000;" class="appelsMail">Date envoi mail<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 19 -->
                                        <th class="infoEmpreinte">Laboratoire</th>
                                        <!-- 20 -->
                                        <th class="infoEmpreinte">Date D'empreinte</th>
                                        <!-- 21 -->
                                        <th class="infoEmpreinte">Date d'envoi au labo</th>
                                        <!-- 22 -->
                                        <th class="infoEmpreinte">Travail demandé</th>
                                        <!-- 23 -->
                                        <th class="infoEmpreinte">N° dent</th>
                                        <!-- 24 -->
                                        <th  style="border-right: 2px solid #000;" class="infoEmpreinte">Observations</th>
                                        <!-- 25 -->
                                        <th class="retourLabo">Date livraison</th>
                                        <!-- 26 -->
                                        <th class="retourLabo">numero suivi colis de retour<br>+ société de livraison</th>
                                        <!-- 27 -->
                                        <th style="border-right: 2px solid #000;" class="retourLabo">N° Facture Labo</th>
                                        <!-- 28 -->
                                        <th class="pose">Date de pose prévue</th>
                                        <!-- 29 -->
                                        <th style="border-right: 2px solid #000;" class="pose">Statut</th>
                                        <!-- 30 -->
                                        <th class="pose">Date de pose réelle</th>
                                        <!-- 31 -->
                                        <th class="travauxCloture">organisme payeur</th>
                                        <!-- 32 -->
                                        <th class="travauxCloture">Montant encaissé</th>
                                        <!-- 33 -->
                                        <th style="border-right: 2px solid #000;" class="travauxCloture">date ou vous devez <br>controler paiement</th>
                                        <th class="infoCheques">Numéro de chèque</th>
                                        <th class="infoCheques">Montant du chèque</th>
                                        <th class="infoCheques">Nom document</th>
                                        <th class="infoCheques">Date d'encaissement chq</th>
                                        <th class="infoCheques">Date de 1er L'acte</th>
                                        <th class="infoCheques">Nature du chèque</th>
                                        <th class="infoCheques">Tavaux Sur le Devis</th>
                                        <th class="infoCheques">Situation chèque</th>
                                        <th class="infoCheques">Observation</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($deviss as $devis)
                                        <tr style="background-color: {{ $devis->couleur }};" onmouseover="this.style.backgroundColor='#d3d3d3';" onmouseout="this.style.backgroundColor='{{ $devis->couleur }}';">
                                            <!-- INFO DEVIS -->
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                <strong>{{ $devis->dossier }}</strong>
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer; word-wrap: break-word; max-width: 150px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->nom }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->status }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->mutuelle }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getMontant() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                @if($devis->devis_signe == 'oui')
                                                    <label class="badge badge-info">Oui</label>
                                                @else
                                                    Non
                                                @endif
                                            </td>
                                            <td class="infoCheques" style="border-right: 2px solid #000;" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->praticien }}
                                            </td>

                                            <!-- INFO ACCORD PEC -->
                                            <td class="infoAccordPec" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_envoi_pec() }}
                                            </td>
                                            <td class="infoAccordPec" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_fin_validite_pec() }}
                                            </td>
                                            <td class="infoAccordPec" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getPart_mutuelle() }}
                                            </td>
                                            <td class="infoAccordPec" style="border-right: 2px solid #000;" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getPart_rac() }}
                                            </td>

                                            <!-- APPELS & MAIL -->
                                            <td class="appelsMail" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_1er_appel() }}
                                            </td>
                                            <td class="appelsMail" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer; word-wrap: break-word; max-width: 175px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->getNote_1er_appel() }}
                                            </td>
                                            <td class="appelsMail" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_2eme_appel() }}
                                            </td>
                                            <td class="appelsMail" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer; word-wrap: break-word; max-width: 175px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->getNote_2eme_appel() }}
                                            </td>
                                            <td class="appelsMail" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_3eme_appel() }}
                                            </td>
                                            <td class="appelsMail" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer; word-wrap: break-word; max-width: 175px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->getNote_3eme_appel() }}
                                            </td>
                                            <td class="appelsMail" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer; border-right: 2px solid #000;">
                                                {{ $devis->getDate_envoi_mail() }}
                                            </td>
                                            <td class="infoEmpreinte" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getLaboratoire() }}
                                            </td>
                                            <td class="infoEmpreinte" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_empreinte() }}
                                            </td>
                                            <td class="infoEmpreinte" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_envoi_labo() }}
                                            </td>
                                            <td class="infoEmpreinte" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getTravail_demande() }}
                                            </td>
                                            <td class="infoEmpreinte" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getNumero_dent() }}
                                            </td>
                                            <td class="infoEmpreinte" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer; border-right: 2px solid #000;">
                                                {{ $devis->getObservations() }}
                                            </td>
                                            <td class="retourLabo" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_livraison() }}
                                            </td>
                                            <td class="retourLabo" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getNumero_suivi() }}
                                            </td>
                                            <td class="retourLabo" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer; border-right: 2px solid #000;">
                                                {{ $devis->getNumero_facture_labo() }}
                                            </td>
                                            <td class="pose" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_pose_prevue() }}
                                            </td>
                                            <td class="pose" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer; border-right: 2px solid #000;">
                                                {{ $devis->getPoseStatut() }}
                                            </td>
                                            <td class="pose" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_pose_reel() }}
                                            </td>
                                            <td class="travauxCloture" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getOrganisme_payeur() }}
                                            </td>
                                            <td class="travauxCloture" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getMontant_encaisse() }}
                                            </td>
                                            <td class="travauxCloture" style="border-right: 2px solid #000;" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_controle_paiement() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getNumero_cheque() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getMontant_cheque() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getNom_document() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_encaissement_cheque() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_1er_acte() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getNature_cheque() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getTravaux_sur_devis() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getSituation_cheque() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getCheque_observation() }}
                                            </td>

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
