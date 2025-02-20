@extends('layouts.app')
@section('content')
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            Sélectionner des options
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li class="dropdown-item">
                <input type="checkbox" name="options[]" value="Option 1" id="option1">
                <label for="option1">Option 1</label>
            </li>
            <li class="dropdown-item">
                <input type="checkbox" name="options[]" value="Option 2" id="option2">
                <label for="option2">Option 2</label>
            </li>
            <li class="dropdown-item">
                <input type="checkbox" name="options[]" value="Option 3" id="option3">
                <label for="option3">Option 3</label>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-lg-12 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Liste des devis</h4>
                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <div>
                                    <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal" data-bs-target="#fileModal">
                                        <i class="icon-upload"></i> Import
                                    </a>
                                    <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal" data-bs-target="#dateModal">
                                        <i class="icon-download"></i> Export
                                    </a>
                                    <a href="{{ asset('devis/nouveau') }}" class="text-primary">
                                        <i class="mdi mdi-plus mdi-24px">Nouveau</i>
                                    </a>
                                </div>
                            </div>

                            <div class="col-6">
                                <label for="searchInput1" class="form-label"></label>
                                <input type="text" id="searchInput1" onkeyup="searchTable('searchInput1', 'myTable')" placeholder="Rechercher..." class="form-control">
                            </div>
                            <div class="col-6">
                                <button class="btn btn-primary" style="color: whitesmoke" data-bs-toggle="modal" data-bs-target="#modalForm">
                                    Recherche spécifique
                                </button>
                            </div>
                            <div class="col-6">
                                <form action="">
                                    <button class="btn btn-primary" style="color: whitesmoke">
                                        Tout
                                    </button>
                                </form>
                            </div>

                            <div class="container">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label><input type="checkbox" checked disabled> INFO DEVIS</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label><input type="checkbox" checked onclick="toggleColumnVisibility()"> INFO ACCORD PEC</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label><input type="checkbox" checked onclick="toggleColumnVisibility()"> APPELS & MAIL</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label><input type="checkbox" checked onclick="toggleColumnVisibility()"> INFO D'EMPREINTE</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label><input type="checkbox" checked onclick="toggleColumnVisibility()"> RETOUR LABO</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label><input type="checkbox" checked onclick="toggleColumnVisibility()"> POSE</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label><input type="checkbox" checked onclick="toggleColumnVisibility()"> TRAVAUX CLOTURE</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label><input type="checkbox" checked onclick="toggleColumnVisibility()"> INFO CHEQUES</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $deviss->links('pagination::bootstrap-4') }}
                            </div>
                            <div class="table-responsive  mt-1">
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                    <!-- Section INFO DEVIS -->
                                    <tr>
                                        <th class="infoCheques" colspan="8" style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">INFO DEVIS</th>
                                        <th class="infoCheques" colspan="1" style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;"></th>
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
                                        <th onclick="sortTableByString('myTable', 2)" class="infoCheques">Mutuelle<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 3 -->
                                        <th onclick="sortTableByString('myTable', 3)" class="infoCheques">Status<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 4 -->
                                        <th onclick="sortTableByDate('myTable', 4)" class="infoCheques">Date<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 5 -->
                                        <th onclick="sortTableByNumber('myTable', 5)" class="infoCheques">Montant<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 6 -->
                                        <th onclick="sortTableByString('myTable', 6)" class="infoCheques">Devis signé<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 7 -->
                                        <th onclick="sortTableByString('myTable', 7)" style="border-right: 2px solid #000;" class="infoCheques">Praticien<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 8 -->
                                        <th onclick="sortTableByString('myTable', 8)" style="border-right: 2px solid #000;" class="infoCheques">Observation<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- INFO ACCORD PEC -->
                                        <!-- 9 -->
                                        <th onclick="sortTableByDate('myTable', 9)" class="infoAccordPec">Date envoie PEC<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 10 -->
                                        <th onclick="sortTableByDate('myTable', 10)" class="infoAccordPec">Date fin validité PEC<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 11 -->
                                        <th onclick="sortTableByNumber('myTable', 11)" class="infoAccordPec">Part mutuelle<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 12 -->
                                        <th onclick="sortTableByNumber('myTable', 12)" style="border-right: 2px solid #000;" class="infoAccordPec">Part RAC<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- APPELS & MAIL -->
                                        <!-- 13 -->
                                        <th onclick="sortTableByDate('myTable', 13)" class="appelsMail">Date 1er appel<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 14 -->
                                        <th class="appelsMail">Note 1er appel</th>
                                        <!-- 15 -->
                                        <th onclick="sortTableByDate('myTable', 15)" class="appelsMail">Date 2ème appel<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 16 -->
                                        <th class="appelsMail">Note 2ème appel</th>
                                        <!-- 17 -->
                                        <th onclick="sortTableByDate('myTable', 17)" class="appelsMail">Date 3ème appel<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 18 -->
                                        <th class="appelsMail">Note 3ème appel</th>
                                        <!-- 19 -->
                                        <th onclick="sortTableByDate('myTable', 19)" style="border-right: 2px solid #000;" class="appelsMail">Date envoi mail<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 20 -->
                                        <th class="infoEmpreinte">Laboratoire</th>
                                        <!-- 21 -->
                                        <th class="infoEmpreinte">Date D'empreinte</th>
                                        <!-- 22 -->
                                        <th class="infoEmpreinte">Date d'envoi au labo</th>
                                        <!-- 23 -->
                                        <th class="infoEmpreinte">Travail demandé</th>
                                        <!-- 24 -->
                                        <th class="infoEmpreinte">N° dent</th>
                                        <!-- 25 -->
                                        <th  style="border-right: 2px solid #000;" class="infoEmpreinte">Observations</th>
                                        <!-- 26 -->
                                        <th class="retourLabo">Date livraison</th>
                                        <!-- 27 -->
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
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                <strong>{{ $devis->dossier }}</strong>
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer; word-wrap: break-word; max-width: 150px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->nom }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->mutuelle }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->status }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getMontant() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                @if($devis->devis_signe == 'oui')
                                                    <label class="badge badge-info">Oui</label>
                                                @else
                                                    Non
                                                @endif
                                            </td>
                                            <td class="infoCheques" style="border-right: 2px solid #000;" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->praticien }}
                                            </td>
                                            <td class="infoCheques" style="border-right: 2px solid #000;" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ \Illuminate\Support\Str::limit($devis->devis_observation, 50, '...') }}
                                            </td>

                                            <!-- INFO ACCORD PEC -->
                                            <td class="infoAccordPec" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_envoi_pec() }}
                                            </td>
                                            <td class="infoAccordPec" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_fin_validite_pec() }}
                                            </td>
                                            <td class="infoAccordPec" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getPart_mutuelle() }}
                                            </td>
                                            <td class="infoAccordPec" style="border-right: 2px solid #000;" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getPart_rac() }}
                                            </td>

                                            <!-- APPELS & MAIL -->
                                            <td class="appelsMail" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_1er_appel() }}
                                            </td>
                                            <td class="appelsMail" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer; word-wrap: break-word; max-width: 175px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->getNote_1er_appel() }}
                                            </td>
                                            <td class="appelsMail" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_2eme_appel() }}
                                            </td>
                                            <td class="appelsMail" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer; word-wrap: break-word; max-width: 175px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->getNote_2eme_appel() }}
                                            </td>
                                            <td class="appelsMail" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_3eme_appel() }}
                                            </td>
                                            <td class="appelsMail" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer; word-wrap: break-word; max-width: 175px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->getNote_3eme_appel() }}
                                            </td>
                                            <td class="appelsMail" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer; border-right: 2px solid #000;">
                                                {{ $devis->getDate_envoi_mail() }}
                                            </td>
                                            <td class="infoEmpreinte" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getLaboratoire() }}
                                            </td>
                                            <td class="infoEmpreinte" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_empreinte() }}
                                            </td>
                                            <td class="infoEmpreinte" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_envoi_labo() }}
                                            </td>
                                            <td class="infoEmpreinte" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getTravail_demande() }}
                                            </td>
                                            <td class="infoEmpreinte" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getNumero_dent() }}
                                            </td>
                                            <td class="infoEmpreinte" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer; border-right: 2px solid #000;">
                                                @if($devis->empreinte_observation) {{ \Illuminate\Support\Str::limit($devis->empreinte_observation, 50, '...') }} @else ... @endif
                                            </td>
                                            <td class="retourLabo" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_livraison() }}
                                            </td>
                                            <td class="retourLabo" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getNumero_suivi() }}
                                            </td>
                                            <td class="retourLabo" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer; border-right: 2px solid #000;">
                                                {{ $devis->getNumero_facture_labo() }}
                                            </td>
                                            <td class="pose" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_pose_prevue() }}
                                            </td>
                                            <td class="pose" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer; border-right: 2px solid #000;">
                                                {{ $devis->getPoseStatut() }}
                                            </td>
                                            <td class="pose" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_pose_reel() }}
                                            </td>
                                            <td class="travauxCloture" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getOrganisme_payeur() }}
                                            </td>
                                            <td class="travauxCloture" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getMontant_encaisse() }}
                                            </td>
                                            <td class="travauxCloture" style="border-right: 2px solid #000;" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_controle_paiement() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getNumero_cheque() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getMontant_cheque() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getNom_document() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_encaissement_cheque() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getDate_1er_acte() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getNature_cheque() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getTravaux_sur_devis() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                {{ $devis->getSituation_cheque() }}
                                            </td>
                                            <td class="infoCheques" onclick="window.location.href='{{ asset($devis->dossier.'/devis/'.$devis->id_devis.'/detail')  }}';" style="cursor:pointer;">
                                                @if($devis->cheque_observation) {{ \Illuminate\Support\Str::limit($devis->cheque_observation, 50, '...') }} @else ... @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $deviss->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel">Sélectionner un fichier .xslx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="importForm" action="{{ asset('devis/import') }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-12">
                                <label for="devisFile">Fichier Excel</label>
                                <input type="file" class="form-control" id="devisFile" name="devisFile" accept=".xlsx">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" id="exportBtn">Importer</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateModalLabel">Sélectionner la période</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="exportForm" action="{{ route('v_devis.export') }}" method="GET">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_devis_debut" class="form-label">Date début</label>
                                <input type="date" id="date_devis_debut" name="date_devis_debut" class="form-control" value="{{ $inp_date_devis_debut }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_devis_fin" class="form-label">Date fin</label>
                                <input type="date" id="date_devis_fin" name="date_devis_fin" class="form-control" value="{{ $inp_date_devis_fin }}">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" id="exportBtn">Exporter</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Recherche Spécifique</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_devis_debut" class="form-label">Date début</label>
                                <input type="date" id="date_devis_debut" name="date_devis_debut" class="form-control" value="{{ $inp_date_devis_debut }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_devis_fin" class="form-label">Date fin</label>
                                <input type="date" id="date_devis_fin" name="date_devis_fin" class="form-control" value="{{ $inp_date_devis_fin }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="montant_min" class="form-label">Montant min</label>
                                <input type="number" id="montant_min" name="montant_min" class="form-control" min="0" step="0.01" value="{{ $inp_montant_min }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="montant_max" class="form-label">Montant max</label>
                                <input type="number" id="montant_max" name="montant_max" class="form-control" min="0" step="0.01" value="{{ $inp_montant_max }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="devis_signe" class="form-label">Devis signé</label>
                                <select id="devis_signe" name="devis_signe" class="form-control">
                                    <option value="">Tout</option>
                                    <option value="oui" @if($inp_devis_signe=="oui") selected @endif>Oui</option>
                                    <option value="non" @if($inp_devis_signe=="non") selected @endif>Non</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Praticiens</label><br>
                                <!-- Boucle Blade pour générer les checkboxes -->
                                @foreach ($praticiens as $praticien)
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="praticien_{{ $praticien->praticien }}">
                                            <input type="checkbox" class="form-check-input" id="praticien_{{ $praticien->praticien }}" name="praticiens[]" value="{{ $praticien->praticien }}" @if (is_null($inp_praticiens) || count($inp_praticiens) === 0 || in_array($praticien->praticien, $inp_praticiens)) checked @endif>
                                            {{ $praticien->praticien }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleColumnVisibility() {
            const columns = [
                { className: 'infoCheques', index: 0 },
                { className: 'infoAccordPec', index: 1 },
                { className: 'appelsMail', index: 2 },
                { className: 'infoEmpreinte', index: 3 },
                { className: 'retourLabo', index: 4 },
                { className: 'pose', index: 5 },
                { className: 'travauxCloture', index: 6 },
                { className: 'infoCheques', index: 7 }
            ];

            const checkboxes = document.querySelectorAll('input[type="checkbox"]');

            // Loop through each checkbox and hide/show columns based on its checked status
            columns.forEach((col) => {
                let isChecked = checkboxes[col.index].checked;

                // Toggle visibility of the header (th) and columns (td)
                let headerElements = document.querySelectorAll(`.${col.className}`);
                headerElements.forEach((el) => {
                    el.style.display = isChecked ? '' : 'none';
                });
            });
        }
    </script>

    <script>
        function searchTable(inputId, tableId) {
            const input = document.getElementById(inputId); // L'élément input pour la recherche
            const filter = input.value.toLowerCase(); // Le texte à rechercher
            const table = document.getElementById(tableId); // La table HTML
            const rows = table.getElementsByTagName('tr'); // Toutes les lignes de la table

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');

                // Vérifier si la ligne contient des cellules <td> (ignorer les lignes d'en-tête avec <th>)
                if (cells.length > 0) {
                    let rowContainsFilter = false;

                    for (let j = 0; j < cells.length; j++) {
                        const cellContent = cells[j].textContent || cells[j].innerText;
                        if (cellContent.toLowerCase().includes(filter)) {
                            rowContainsFilter = true;
                            break;
                        }
                    }

                    // Affiche ou masque la ligne en fonction de la correspondance
                    row.style.display = rowContainsFilter ? '' : 'none';
                }
            }
        }
    </script>
    <script>
        function sortTableByDate(tableId, columnIndex) {
            const table = document.getElementById(tableId);
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.rows);

            // Déterminer l'ordre de tri actuel (ascendant ou descendant)
            const isAscending = !table.dataset.sortAsc || table.dataset.sortAsc === 'false';
            table.dataset.sortAsc = isAscending;

            // Fonction pour analyser une date au format "d/m/Y"
            const parseDate = (dateString) => {
                const [day, month, year] = dateString.split('/').map(Number);
                return new Date(year, month - 1, day);
            };

            // Trier les lignes selon les dates
            rows.sort((rowA, rowB) => {
                const dateA = parseDate(rowA.cells[columnIndex].innerText.trim());
                const dateB = parseDate(rowB.cells[columnIndex].innerText.trim());
                return isAscending ? dateA - dateB : dateB - dateA;
            });

            // Réinsérer les lignes triées dans le tableau
            tbody.innerHTML = '';
            rows.forEach(row => tbody.appendChild(row));
        }
    </script>
    <script>
        function sortTableByNumber(tableId, columnIndex) {
            const table = document.getElementById(tableId);
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.rows);

            // Déterminer l'ordre de tri actuel (ascendant ou descendant)
            const isAscending = !table.dataset.sortAsc || table.dataset.sortAsc === 'false';
            table.dataset.sortAsc = isAscending;

            // Fonction pour convertir le format "number_format" en un nombre JavaScript
            const parseNumber = (numberString) => {
                // Supprimer les espaces comme séparateurs de milliers et remplacer les virgules par des points
                return parseFloat(numberString.replace(/\s/g, '').replace(',', '.').replace('...','0'));
            };

            // Trier les lignes selon les nombres
            rows.sort((rowA, rowB) => {
                const numberA = parseNumber(rowA.cells[columnIndex].innerText.trim());
                const numberB = parseNumber(rowB.cells[columnIndex].innerText.trim());
                return isAscending ? numberA - numberB : numberB - numberA;
            });

            // Réinsérer les lignes triées dans le tableau
            tbody.innerHTML = '';
            rows.forEach(row => tbody.appendChild(row));
        }
    </script>
    <script>
        function sortTableByString(tableId, columnIndex) {
            const table = document.getElementById(tableId);
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.rows);

            // Déterminer l'ordre de tri actuel (ascendant ou descendant)
            const isAscending = !table.dataset.sortAsc || table.dataset.sortAsc === 'false';
            table.dataset.sortAsc = isAscending;

            // Trier les lignes par les valeurs textuelles de la colonne
            rows.sort((rowA, rowB) => {
                const textA = rowA.cells[columnIndex].innerText.trim().toLowerCase();
                const textB = rowB.cells[columnIndex].innerText.trim().toLowerCase();
                if (isAscending) {
                    return textA.localeCompare(textB);
                } else {
                    return textB.localeCompare(textA);
                }
            });

            // Réinsérer les lignes triées dans le tableau
            tbody.innerHTML = '';
            rows.forEach(row => tbody.appendChild(row));
        }
    </script>




@endsection
