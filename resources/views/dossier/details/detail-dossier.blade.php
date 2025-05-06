@extends('layouts.app')
@section('content')
    <style>
        tr:hover {
            background-color: #d3d3d3; /* Couleur de fond au survol */
        }
        .card-header {
            background: linear-gradient(
                -135deg,
                transparent 60%,
                #575756 60%,
                #575756 100%);
        }
    </style>

    <div class="row mt-4">
        <div class="d-sm-flex align-items-center justify-content-between border-bottom">
            <div>
                <div class="btn-wrapper">
                    <a href="{{ asset('modifier-dossier/'.$dossier->dossier) }}" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Modifier le dossier</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header text-white d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title mb-0" style="color: whitesmoke">{{ $dossier->dossier }} - {{ $dossier->nom }}: Liste des devis </h4>
                    </div>
                    <div>
                        <a href="{{ asset($dossier->dossier.'/nouveau-devis') }}" class="text-primary">
                            <i class="mdi mdi-plus mdi-24px">Nouveau devis</i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="myTable">
                            <thead>
                                <!-- Section INFO DEVIS -->
                                <tr>
                                    <th class="infoDevis" colspan="8"
                                        style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">
                                        INFO DEVIS
                                    </th>
                                    <th class="infoDevis" colspan="1"
                                        style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;"></th>
                                    <th class="infoAccordPec" colspan="5"
                                        style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">
                                        INFO ACCORD PEC
                                    </th>
                                    <th class="appelsMail" colspan="7"
                                        style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">
                                        APPELS & MAIL
                                    </th>
                                    <th class="infoEmpreinte" colspan="7"
                                        style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">
                                        INFO D'EMPREINTE
                                    </th>
                                    <th class="retourLabo" colspan="3"
                                        style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">
                                        RETOUR LABO
                                    </th>
                                    <th class="pose" colspan="2"
                                        style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">
                                        POSE
                                    </th>
                                    <th class="travauxCloture" colspan="4"
                                        style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">
                                        TRAVAUX CLOTURE
                                    </th>
                                    <th class="infoCheques" colspan="9"
                                        style="background-color: #f8f9fa; text-align: center;">INFO CHEQUES
                                    </th>
                                </tr>
                                <tr>
                                    <!-- INFO DEVIS -->
                                    <!-- triTableau(tableId, columnIndex, isText = true, isNumber = false, isDate = false) -->
                                    <!-- 0 -->
                                    <th onclick="sortTableByString('myTable', 0)" class="infoDevis">Dossier<span
                                            id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 1 -->
                                    <th onclick="sortTableByString('myTable', 1)" class="infoDevis">Patient<span
                                            id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 2 -->
                                    <th onclick="sortTableByString('myTable', 2)" class="infoDevis">Mutuelle<span
                                            id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 3 -->
                                    <th onclick="sortTableByString('myTable', 3)" class="infoDevis">Status<span
                                            id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 4 -->
                                    <th onclick="sortTableByDate('myTable', 4)" class="infoDevis">Date<span
                                            id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 5 -->
                                    <th onclick="sortTableByNumber('myTable', 5)" class="infoDevis">Montant<span
                                            id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 6 -->
                                    <th onclick="sortTableByString('myTable', 6)" class="infoDevis">Devis
                                        signé<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 7 -->
                                    <th onclick="sortTableByString('myTable', 7)"
                                        style="border-right: 2px solid #000;" class="infoDevis">Praticien<span
                                            id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 8 -->
                                    <th onclick="sortTableByString('myTable', 8)"
                                        style="border-right: 2px solid #000;" class="infoDevis">Observation<span
                                            id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- INFO ACCORD PEC -->
                                    <!-- 9 -->
                                    <th onclick="sortTableByDate('myTable', 9)" class="infoAccordPec">Date envoie
                                        PEC<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 10 -->
                                    <th onclick="sortTableByDate('myTable', 10)" class="infoAccordPec">Date fin
                                        validité PEC<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 11 -->
                                    <th onclick="sortTableByNumber('myTable', 11)" class="infoAccordPec">Part
                                        Sécu<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 11 -->
                                    <th onclick="sortTableByNumber('myTable', 11)" class="infoAccordPec">Part
                                        mutuelle<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 12 -->
                                    <th onclick="sortTableByNumber('myTable', 12)"
                                        style="border-right: 2px solid #000;" class="infoAccordPec">Part RAC<span
                                            id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- APPELS & MAIL -->
                                    <!-- 13 -->
                                    <th onclick="sortTableByDate('myTable', 13)" class="appelsMail">Date 1er
                                        appel<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 14 -->
                                    <th class="appelsMail">Note 1er appel</th>
                                    <!-- 15 -->
                                    <th onclick="sortTableByDate('myTable', 15)" class="appelsMail">Date 2ème
                                        appel<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 16 -->
                                    <th class="appelsMail">Note 2ème appel</th>
                                    <!-- 17 -->
                                    <th onclick="sortTableByDate('myTable', 17)" class="appelsMail">Date 3ème
                                        appel<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 18 -->
                                    <th class="appelsMail">Note 3ème appel</th>
                                    <!-- 19 -->
                                    <th onclick="sortTableByDate('myTable', 19)"
                                        style="border-right: 2px solid #000;" class="appelsMail">Date envoi
                                        mail<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    <!-- 20 -->
                                    <th class="infoEmpreinte">Laboratoire</th>
                                    <!-- 21 -->
                                    <th class="infoEmpreinte">Date D'empreinte</th>
                                    <!-- 22 -->
                                    <th class="infoEmpreinte">Date d'envoi au labo</th>
                                    <!-- 23 -->
                                    <th class="infoEmpreinte">Travail demandé</th>
                                    <!-- 23 -->
                                    <th class="infoEmpreinte">Montant Acte</th>
                                    <!-- 24 -->
                                    <th class="infoEmpreinte">N° dent</th>
                                    <!-- 25 -->
                                    <th style="border-right: 2px solid #000;" class="infoEmpreinte">Observations
                                    </th>
                                    <!-- 26 -->
                                    <th class="retourLabo">Date livraison</th>
                                    <!-- 27 -->
                                    <th class="retourLabo">numero suivi colis de retour<br>+ société de livraison
                                    </th>
                                    <!-- 27 -->
                                    <th style="border-right: 2px solid #000;" class="retourLabo">N° Facture Labo
                                    </th>
                                    <!-- 28 -->
                                    <th class="pose">Date de pose prévue</th>
                                    <!-- 29 -->
                                    <th style="border-right: 2px solid #000;" class="pose">Statut</th>
                                    <!-- 30 -->
                                    <th class="travauxCloture">Date de pose réelle</th>
                                    <!-- 31 -->
                                    <th class="travauxCloture">organisme payeur</th>
                                    <!-- 32 -->
                                    <th class="travauxCloture">Montant encaissé</th>
                                    <!-- 33 -->
                                    <th style="border-right: 2px solid #000;" class="travauxCloture">date ou vous
                                        devez <br>controler paiement
                                    </th>
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
                                    @php
                                        $id_devis = null;
                                    @endphp
                                    @foreach($deviss as $devis)
                                        @php
                                            $couleur_reste_a_payer = '';
                                            if($devis->reste_a_payer > 0){
                                                $couleur_reste_a_payer = 'red';
                                            }else if($devis->reste_a_payer < 0){
                                                $couleur_reste_a_payer = 'red';
                                            }else if($devis->reste_a_payer == 0){
                                                $couleur_reste_a_payer = 'green';
                                            }
                                            if($devis->montant_acte == 0 || $devis->montant_acte == null || $devis->montant_acte == ''){
                                                $couleur_reste_a_payer = 'red';
                                            }
                                            $couleur_info_accord_pec = "";
                                            if($devis->part_secu == null && $devis->part_mutuelle == null && $devis->part_rac == null){
                                                $couleur_info_accord_pec = 'red';
                                            }
                                            $couleur_font = '';
                                            if ($id_devis == $devis->id_devis) {
                                                $couleur_font = "transparent";
                                            }
                                        @endphp
                                        <tr style="background-color: {{ $devis->couleur }};"
                                            onmouseover="this.style.backgroundColor='#d3d3d3';"
                                            onmouseout="this.style.backgroundColor='{{ $devis->couleur }}';">
                                            <!-- INFO DEVIS -->
                                            <td class="infoDevis"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                <strong>{{ $devis->dossier }}</strong>
                                            </td>
                                            <td class="infoDevis"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; word-wrap: break-word; max-width: 150px; overflow: hidden; text-overflow: ellipsis; color: {{ $couleur_font }};">
                                                {{ $devis->nom }}
                                            </td>
                                            <td class="infoDevis"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->mutuelle }}
                                            </td>
                                            <td class="infoDevis"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->status }}
                                            </td>
                                            <td class="infoDevis"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getDate() }}
                                            </td>
                                            <td class="infoDevis"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; background-color: {{ $couleur_info_accord_pec }}; color: {{ $couleur_font }};">
                                                {{ $devis->getMontant() }}
                                            </td>
                                            <td class="infoDevis"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                @if($devis->devis_signe == 'oui')
                                                    <label class="badge badge-info">Oui</label>
                                                @else
                                                    Non
                                                @endif
                                            </td>
                                            <td class="infoDevis" style="border-right: 2px solid #000; color: {{ $couleur_font }};"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->praticien }}
                                            </td>
                                            <td class="infoDevis" style="border-right: 2px solid #000; color: {{ $couleur_font }};"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ Str::limit($devis->devis_observation, 50) }}
                                            </td>

                                            <!-- INFO ACCORD PEC -->
                                            <td class="infoAccordPec"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getDate_envoi_pec() }}
                                            </td>
                                            <td class="infoAccordPec"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getDate_fin_validite_pec() }}
                                            </td>
                                            <td class="infoAccordPec"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer color: {{ $couleur_font }};; @foreach($devis_accord_pecs_status as $da) @if($da->status == $devis->part_secu_status) background-color: {{ $da->couleur }} @endif @endforeach">
                                                {{ $devis->getPart_secu() }}
                                            </td>
                                            <td class="infoAccordPec"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }}; @foreach($devis_accord_pecs_status as $da) @if($da->status == $devis->part_mutuelle_status) background-color: {{ $da->couleur }} @endif @endforeach">
                                                {{ $devis->getPart_mutuelle() }}
                                            </td>
                                            @php
                                                foreach ($devis_accord_pecs_status as $da) {
                                                    if($da->status == $devis->part_rac_status){
                                                        $couleur = $da->couleur;
                                                    }
                                                }
                                            @endphp
                                            <td class="infoAccordPec" style="border-right: 2px solid #000; cursor:pointer; background-color: {{ $couleur }}; color: {{ $couleur_font }};"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';">
                                                {{ $devis->getPart_rac() }}
                                            </td>

                                            <!-- APPELS & MAIL -->
                                            <td class="appelsMail"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getDate_1er_appel() }}
                                            </td>
                                            <td class="appelsMail"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; word-wrap: break-word; max-width: 175px; overflow: hidden; text-overflow: ellipsis; color: {{ $couleur_font }};">
                                                {{ $devis->getNote_1er_appel() }}
                                            </td>
                                            <td class="appelsMail"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getDate_2eme_appel() }}
                                            </td>
                                            <td class="appelsMail"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; word-wrap: break-word; max-width: 175px; overflow: hidden; text-overflow: ellipsis; color: {{ $couleur_font }};">
                                                {{ $devis->getNote_2eme_appel() }}
                                            </td>
                                            <td class="appelsMail"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getDate_3eme_appel() }}
                                            </td>
                                            <td class="appelsMail"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }}; word-wrap: break-word; max-width: 175px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->getNote_3eme_appel() }}
                                            </td>
                                            <td class="appelsMail"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; border-right: 2px solid #000; color: {{ $couleur_font }};">
                                                {{ $devis->getDate_envoi_mail() }}
                                            </td>
                                            <td class="infoEmpreinte"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->getLaboratoire() }}
                                            </td>
                                            <td class="infoEmpreinte"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->getDate_empreinte() }}
                                            </td>
                                            <td class="infoEmpreinte"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->getDate_envoi_labo() }}
                                            </td>
                                            <td class="infoEmpreinte"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->getTravail_demande() }}
                                            </td>
                                            <td class="infoEmpreinte"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; background-color: {{ $couleur_reste_a_payer }}">
                                                {{ $devis->getMontantActe() }}
                                            </td>
                                            <td class="infoEmpreinte"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->getNumero_dent() }}
                                            </td>
                                            <td class="infoEmpreinte"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; border-right: 2px solid #000;">
                                                @if($devis->empreinte_observation)
                                                    {{ Str::limit($devis->empreinte_observation, 50) }}
                                                @else
                                                    ...
                                                @endif
                                            </td>
                                            <td class="retourLabo"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->getDate_livraison() }}
                                            </td>
                                            <td class="retourLabo"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->getNumero_suivi() }}
                                            </td>
                                            <td class="retourLabo"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; border-right: 2px solid #000;">
                                                {{ $devis->getNumero_facture_labo() }}
                                            </td>
                                            <td class="pose"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->getDate_pose_prevue() }}
                                            </td>
                                            <td class="pose"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; border-right: 2px solid #000;">
                                                {{ $devis->getPoseStatut() }}
                                            </td>
                                            <td class="travauxCloture"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->getDate_pose_reel() }}
                                            </td>
                                            <td class="travauxCloture"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->getOrganisme_payeur() }}
                                            </td>
                                            <td class="travauxCloture"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->getMontant_encaisse() }}
                                            </td>
                                            <td class="travauxCloture" style="border-right: 2px solid #000;"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer;">
                                                {{ $devis->getDate_controle_paiement() }}
                                            </td>
                                            <td class="infoCheques"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getNumero_cheque() }}
                                            </td>
                                            <td class="infoCheques"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getMontant_cheque() }}
                                            </td>
                                            <td class="infoCheques"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getNom_document() }}
                                            </td>
                                            <td class="infoCheques"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getDate_encaissement_cheque() }}
                                            </td>
                                            <td class="infoCheques"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getDate_1er_acte() }}
                                            </td>
                                            <td class="infoCheques"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getNature_cheque() }}
                                            </td>
                                            <td class="infoCheques"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getTravaux_sur_devis() }}
                                            </td>
                                            <td class="infoCheques"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                {{ $devis->getSituation_cheque() }}
                                            </td>
                                            <td class="infoCheques"
                                                ondblclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/acte'.$devis->id_acte.'/detail')  }}';"
                                                style="cursor:pointer; color: {{ $couleur_font }};">
                                                @if($devis->cheque_observation)
                                                    {{ Str::limit($devis->cheque_observation, 50) }}
                                                @else
                                                    ...
                                                @endif
                                            </td>
                                            <td ondblclick="event.stopPropagation()"><a href="{{ asset('deleteDevis/'.$devis->id_devis.'/'.$devis->id_acte) }}" onclick="return deleteItem('<?= $devis->dossier ?>', '<?= $devis->date ?>')">Supprimer</a></td>
                                        </tr>
                                        @php
                                            $id_devis = $devis->id_devis;
                                        @endphp
                                    @endforeach
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
                <div class="card-header text-white d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title mb-0" style="color: whitesmoke">{{ $dossier->dossier }} - {{ $dossier->nom }}: CA </h4>
                    </div>
                    <div>
                        <a href="{{ asset('ca/nouveau/'.$dossier->dossier) }}" class="text-primary">
                            <i class="mdi mdi-plus mdi-24px">Nouveau CA</i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th colspan="5" style="background-color: #f3f3f3; text-align: center; border-right: 2px solid #000;"></th>
                                <th colspan="4" style="background-color: #fff2cc; text-align: center; border-right: 2px solid #000;"></th>
                                <th colspan="5" style="background-color: #f9cb9c; text-align: center; border-right: 2px solid #000;">RO</th>
                                <th colspan="1" style="background-color: #cfe2f3; text-align: center; border-right: 2px solid #000;"></th>
                                <th colspan="3" style="background-color: #6d9eeb; text-align: center; border-right: 2px solid #000;">RC SOINS</th>
                                <th colspan="3" style="background-color: #76a5af; text-align: center; border-right: 2px solid #000;">RC soins avec DEVIS</th>
                                <th colspan="4" style="background-color: #d9d2e9; text-align: center; border-right: 2px solid #000;">RAC</th>
                            </tr>
                            <tr>
                                <th style="background-color: #f3f3f3">Date de dernière modif</th>
                                <th style="background-color: #f3f3f3">N° dossier</th>
                                <th style="background-color: #f3f3f3">Nom du patient</th>
                                <th style="background-color: #f3f3f3">Statut</th>
                                <th style="background-color: #f3f3f3; border-right: 2px solid #000;">Mutuelle</th>
                                <th style="background-color: #fff2cc">Praticien</th>
                                <th style="background-color: #fff2cc">Acte</th>
                                <th style="background-color: #fff2cc">Cotation</th>
                                <th style="background-color: #fff2cc; border-right: 2px solid #000;">Contrôle sécurisation</th>
                                <th style="background-color: #f3f3f3">Part Sécu</th>
                                <th style="background-color: #f3f3f3">Virement reçu</th>
                                <th style="background-color: #f3f3f3">Indus payé</th>
                                <th style="background-color: #f3f3f3">Indus en attente</th>
                                <th style="background-color: #f3f3f3; border-right: 2px solid #000;">Indus irrecouvrable</th>
                                <th style="background-color: #cfe2f3; border-right: 2px solid #000;">Part Mutuelle</th>
                                <th style="background-color: #f3f3f3">Virement</th>
                                <th style="background-color: #f3f3f3">Espèces</th>
                                <th style="background-color: #f3f3f3; border-right: 2px solid #000;">CB</th>
                                <th style="background-color: #f3f3f3">Chèque</th>
                                <th style="background-color: #f3f3f3">Espèces</th>
                                <th style="background-color: #f3f3f3; border-right: 2px solid #000;">CB</th>
                                <th style="background-color: #f3f3f3">Part patient</th>
                                <th style="background-color: #f3f3f3">Chèque</th>
                                <th style="background-color: #f3f3f3">Espèces</th>
                                <th style="background-color: #f3f3f3; border-right: 2px solid #000;">CB</th>
                                <th style="background-color: #f3f3f3">Commentaire</th>
                                <th style="background-color: #f3f3f3">Date de création</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($ca_actes_reglements as $ca)
                                @php
                                    $cotation_restant = $ca->cotation - $ca->cotation_paye;
                                    $part_secu_restant = ($ca->ro_part_secu ?? 0) - $ca->ro_part_secu_paye;
                                    $part_mutuelle_restant = ($ca->part_mutuelle ?? 0) - $ca->part_mutuelle_paye;
                                    $rac_part_patient_restant = ($ca->rac_part_patient ?? 0) - $ca->rac_part_patient_paye;
                                @endphp
                                <tr ondblclick="window.location.href='{{ asset('ca/'.$ca->id_ca_actes_reglement.'/'.$ca->dossier.'/modifier') }}';">
                                    <td>
                                        @if($ca->date_derniere_modif)
                                            {{ \Carbon\Carbon::parse($ca->date_derniere_modif)->format('Y-m-d') }}
                                        @else
                                            ...
                                        @endif
                                    </td>
                                    <td>{{ $ca->dossier }}</td>
                                    <td>{{ $ca->nom }}</td>
                                    <td>{{ $ca->statut }}</td>
                                    <td style="border-right: 2px solid #000;">{{ $ca->mutuelle }}</td>
                                    <td>{{ $ca->praticien }}</td>
                                    <td>{{ $ca->nom_acte }}</td>
                                    <!-- -->    <td class="text-end" style="@if($cotation_restant < 0) background-color: red; @elseif($cotation_restant > 0) background-color: orange; @endif">@if($ca->cotation){{ number_format($ca->cotation, 2, ',', ' ') }}@endif</td>
                                    <td style="border-right: 2px solid #000;">{{ $ca->controle_securisation }}</td>
                                    <!-- -->    <td class="text-end" style="@if($cotation_restant < 0 || $part_secu_restant < 0) background-color: red; @elseif($cotation_restant > 0 || $part_secu_restant > 0) background-color: orange; @endif">
                                        @if($ca->ro_part_secu){{ number_format($ca->ro_part_secu, 2, ',', ' ') }}@endif
                                    </td>
                                    <td class="text-end" style="@if($part_secu_restant < 0) background-color: red; @elseif($part_secu_restant > 0) background-color: orange; @endif">@if($ca->ro_virement_recu){{ number_format($ca->ro_virement_recu, 2, ',', ' ') }}@endif</td>
                                    <td class="text-end" style="@if($part_secu_restant < 0) background-color: red; @elseif($part_secu_restant > 0) background-color: orange; @endif">@if($ca->ro_indus_paye){{ number_format($ca->ro_indus_paye, 2, ',', ' ') }}@endif</td>
                                    <td class="text-end" style="@if($part_secu_restant < 0) background-color: red; @elseif($part_secu_restant > 0) background-color: orange; @endif">@if($ca->ro_indus_en_attente){{ number_format($ca->ro_indus_en_attente, 2, ',', ' ') }}@endif</td>
                                    <td class="text-end" style="@if($part_secu_restant < 0) background-color: red; @elseif($part_secu_restant > 0) background-color: orange; @endif border-right: 2px solid #000;">@if($ca->ro_indus_irrecouvrable){{ number_format($ca->ro_indus_irrecouvrable, 2, ',', ' ') }}@endif</td>
                                    <!-- -->    <td class="text-end" style="@if($cotation_restant < 0 || $part_mutuelle_restant < 0) background-color: red; @elseif($cotation_restant > 0 || $part_mutuelle_restant > 0) background-color: orange; @endif border-right: 2px solid #000; ">
                                        @if($ca->part_mutuelle){{ number_format($ca->part_mutuelle, 2, ',', ' ') }}@endif
                                    </td>
                                    <td class="text-end" style="@if($part_mutuelle_restant < 0) background-color: red; @elseif($part_mutuelle_restant > 0) background-color: orange; @endif">@if($ca->rcs_virement){{ number_format($ca->rcs_virement, 2, ',', ' ') }}@endif</td>
                                    <td class="text-end" style="@if($part_mutuelle_restant < 0) background-color: red; @elseif($part_mutuelle_restant > 0) background-color: orange; @endif">@if($ca->rcs_especes){{ number_format($ca->rcs_especes, 2, ',', ' ') }}@endif</td>
                                    <td class="text-end" style="@if($part_mutuelle_restant < 0) background-color: red; @elseif($part_mutuelle_restant > 0) background-color: orange; @endif border-right: 2px solid #000;">@if($ca->rcs_cb){{ number_format($ca->rcs_cb, 2, ',', ' ') }}@endif</td>
                                    <td class="text-end" style="@if($part_mutuelle_restant < 0) background-color: red; @elseif($part_mutuelle_restant > 0) background-color: orange; @endif">@if($ca->rcsd_cheque){{ number_format($ca->rcsd_cheque, 2, ',', ' ') }}@endif</td>
                                    <td class="text-end" style="@if($part_mutuelle_restant < 0) background-color: red; @elseif($part_mutuelle_restant > 0) background-color: orange; @endif">@if($ca->rcsd_especes){{ number_format($ca->rcsd_especes, 2, ',', ' ') }}@endif</td>
                                    <td class="text-end" style="@if($part_mutuelle_restant < 0) background-color: red; @elseif($part_mutuelle_restant > 0) background-color: orange; @endif border-right: 2px solid #000;">@if($ca->rcsd_cb){{ number_format($ca->rcsd_cb, 2, ',', ' ') }}@endif</td>
                                    <!-- -->    <td class="text-end" style="@if($cotation_restant < 0 || $rac_part_patient_restant < 0 ) background-color: red; @elseif($cotation_restant > 0 || $rac_part_patient_restant > 0) background-color: orange; @endif">
                                        @if($ca->rac_part_patient){{ number_format($ca->rac_part_patient, 2, ',', ' ') }}@endif
                                    </td>
                                    <td class="text-end" style="@if($rac_part_patient_restant < 0) background-color: red; @elseif($rac_part_patient_restant > 0) background-color: orange; @endif">@if($ca->rac_cheque){{ number_format($ca->rac_cheque, 2, ',', ' ') }}@endif</td>
                                    <td class="text-end" style="@if($rac_part_patient_restant < 0) background-color: red; @elseif($rac_part_patient_restant > 0) background-color: orange; @endif">@if($ca->rac_especes){{ number_format($ca->rac_especes, 2, ',', ' ') }}@endif</td>
                                    <td class="text-end" style="@if($rac_part_patient_restant < 0) background-color: red; @elseif($rac_part_patient_restant > 0) background-color: orange; @endif border-right: 2px solid #000;">@if($ca->rac_cb){{ number_format($ca->rac_cb, 2, ',', ' ') }}@endif</td>
                                    <td>{{ $ca->commentaire ?: 'Aucun commentaire' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ca->created_at)->format('d-m-Y') }}</td>
                                    <td onclick="event.stopPropagation()"><a href="{{ asset('delete-ca/'. $ca->id ) }}" onclick="return deleteItem('<?= $ca->dossier ?>', '<?= $ca->created_at ?>')">Supprimer</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteItem(dossier, dateCreated) {
            return confirm(`Voulez-vous vraiment supprimer cela ?\nDossier: ${dossier}\nDate: ${dateCreated}`);
        }
    </script>

@endsection
