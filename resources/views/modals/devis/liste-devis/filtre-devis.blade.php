<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormLabel">Recherche par filtre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ asset('getFilterListeDevis') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="row col-md-6">
                            <h4 class="text-center mb-4"
                                style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Etats</h4>
                            <div class="col-md-12 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Etats
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($devis_etats as $de)
                                            <li class="dropdown-item" style="background-color: {{ $de->couleur }}">
                                                <label>
                                                    <input type="checkbox" class="form-check-input"
                                                           name="id_devis_etats[]" value="{{ $de->id }}"
                                                           @if($filters && isset($filters['id_devis_etats']) && in_array($de->id, $filters['id_devis_etats']))
                                                               checked
                                                        @endif
                                                    >
                                                </label>
                                                {{ $de->etat }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-6">
                            <h4 class="text-center mb-4"
                                style="font-size: 24px; color: #2f8ab9; font-weight: bold;">INFO DEVIS</h4>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_devis_debut" class="form-label">Date début</label>
                                            <input type="date" id="date_devis_debut" name="date_devis_debut"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_devis_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_devis_fin" class="form-label">Date fin</label>
                                            <input type="date" id="date_devis_fin" name="date_devis_fin"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_devis_fin'] }}" @endif>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Montant
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="montant_min" class="form-label">Montant min</label>
                                            <input type="number" id="montant_min" name="montant_min"
                                                   class="form-control" min="0" step="0.01"
                                                   @if($filters) value="{{ $filters['montant_min'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="montant_max" class="form-label">Montant max</label>
                                            <input type="number" id="montant_max" name="montant_max"
                                                   class="form-control" min="0" step="0.01"
                                                   @if($filters) value="{{ $filters['montant_max'] }}" @endif>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Praticiens
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($praticiens as $praticien)
                                            <li class="dropdown-item">
                                                <label
                                                    for="praticien_{{ $praticien->praticien }}"></label><input
                                                    type="checkbox" class="form-check-input"
                                                    id="praticien_{{ $praticien->praticien }}" name="praticiens[]"
                                                    value="{{ $praticien->praticien }}"
                                                    @if($filters && isset($filters['praticiens']) && in_array($praticien->praticien, $filters['praticiens']))
                                                        checked
                                                    @endif
                                                >
                                                {{ $praticien->praticien }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Devis signé
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="devis_signe"></label><label
                                                for="devis_signe"></label><input type="radio"
                                                                                 class="form-check-input"
                                                                                 id="devis_signe" name="devis_signe"
                                                                                 value="" checked>
                                            Tout
                                        </li>
                                        <li class="dropdown-item">
                                            <input type="radio" class="form-check-input" id="devis_signe"
                                                   name="devis_signe" value="oui"
                                                   @if($filters && isset($filters['devis_signe']) && $filters['devis_signe'] == 'oui')
                                                       checked
                                                @endif>
                                            Oui
                                        </li>
                                        <li class="dropdown-item">
                                            <input type="radio" class="form-check-input" id="devis_signe"
                                                   name="devis_signe" value="non"
                                                   @if($filters && isset($filters['devis_signe']) && $filters['devis_signe'] == 'non')
                                                       checked
                                                @endif>
                                            Non
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row col-md-6">
                            <h4 class="text-center mb-4"
                                style="font-size: 24px; color: #2f8ab9; font-weight: bold;">INFO ACCORD PEC</h4>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date envoie PEC
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_envoi_pec_debut" class="form-label">Date début</label>
                                            <input type="date" id="date_envoi_pec_debut" name="date_envoi_pec_debut"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_envoi_pec_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_envoi_pec_fin" class="form-label">Date fin</label>
                                            <input type="date" id="date_envoi_pec_fin" name="date_envoi_pec_fin"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_envoi_pec_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_envoi_pec_null[]" value="sans_valeur" @if($filters && isset($filters['date_envoi_pec_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date fin validité PEC
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_fin_validite_pec_debut" class="form-label">Date
                                                début</label>
                                            <input type="date" id="date_fin_validite_pec_debut"
                                                   name="date_fin_validite_pec_debut" class="form-control"
                                                   @if($filters) value="{{ $filters['date_fin_validite_pec_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_fin_validite_pec_fin" class="form-label">Date
                                                fin</label>
                                            <input type="date" id="date_fin_validite_pec_fin"
                                                   name="date_fin_validite_pec_fin" class="form-control"
                                                   @if($filters) value="{{ $filters['date_fin_validite_pec_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_fin_validite_pec_null[]" value="sans_valeur" @if($filters && isset($filters['date_fin_validite_pec_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Non réglés
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="non_regle[]" value="non_regle" @if($filters && isset($filters['non_regle'])) checked @endif>
                                            </label> Afficher que les non-réglés
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Part sécu
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="part_secu_min" class="form-label">Montant min</label>
                                            <input type="number" id="part_secu_min" name="part_secu_min"
                                                   class="form-control" min="0" step="0.01"
                                                   @if($filters) value="{{ $filters['part_secu_min'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="part_secu_max" class="form-label">Montant max</label>
                                            <input type="number" id="part_secu_max" name="part_secu_max"
                                                   class="form-control" min="0" step="0.01"
                                                   @if($filters) value="{{ $filters['part_secu_max'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="part_secu_null[]" value="sans_valeur" @if($filters && isset($filters['part_secu_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Part mutuelle
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="part_mutuelle_min" class="form-label">Montant min</label>
                                            <input type="number" id="part_mutuelle_min" name="part_mutuelle_min"
                                                   class="form-control" min="0" step="0.01"
                                                   @if($filters) value="{{ $filters['part_mutuelle_min'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="part_mutuelle_max" class="form-label">Montant max</label>
                                            <input type="number" id="part_mutuelle_max" name="part_mutuelle_max"
                                                   class="form-control" min="0" step="0.01"
                                                   @if($filters) value="{{ $filters['part_mutuelle_max'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="part_mutuelle_null[]" value="sans_valeur" @if($filters && isset($filters['part_mutuelle_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Part RAC
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="part_rac_min" class="form-label">Montant min</label>
                                            <input type="number" id="part_rac_min" name="part_rac_min"
                                                   class="form-control" min="0" step="0.01"
                                                   @if($filters) value="{{ $filters['part_rac_min'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="part_rac_max" class="form-label">Montant max</label>
                                            <input type="number" id="part_rac_max" name="part_rac_max"
                                                   class="form-control" min="0" step="0.01"
                                                   @if($filters) value="{{ $filters['part_rac_max'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="part_rac_null[]" value="sans_valeur" @if($filters && isset($filters['part_rac_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="row col-md-6">
                            <h4 class="text-center mb-4"
                                style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Appels et Mails</h4>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date 1er appel
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_1er_appel_debut" class="form-label">Date début</label>
                                            <input type="date" id="date_1er_appel_debut" name="date_1er_appel_debut"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_1er_appel_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_1er_appel_fin" class="form-label">Date fin</label>
                                            <input type="date" id="date_1er_appel_fin" name="date_1er_appel_fin"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_1er_appel_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_1er_appel_null[]" value="sans_valeur" @if($filters && isset($filters['date_1er_appel_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date 2eme appel
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_2eme_appel_debut" class="form-label">Date début</label>
                                            <input type="date" id="date_2eme_appel_debut"
                                                   name="date_2eme_appel_debut" class="form-control"
                                                   @if($filters) value="{{ $filters['date_2eme_appel_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_2eme_appel_fin" class="form-label">Date fin</label>
                                            <input type="date" id="date_2eme_appel_fin" name="date_2eme_appel_fin"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_2eme_appel_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_2eme_appel_null[]" value="sans_valeur" @if($filters && isset($filters['date_2eme_appel_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date 3eme appel
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_3eme_appel_debut" class="form-label">Date début</label>
                                            <input type="date" id="date_3eme_appel_debut"
                                                   name="date_3eme_appel_debut" class="form-control"
                                                   @if($filters) value="{{ $filters['date_3eme_appel_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_3eme_appel_fin" class="form-label">Date fin</label>
                                            <input type="date" id="date_3eme_appel_fin" name="date_3eme_appel_fin"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_3eme_appel_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_3eme_appel_null[]" value="sans_valeur" @if($filters && isset($filters['date_3eme_appel_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date envoi mail
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_envoi_mail_debut" class="form-label">Date début</label>
                                            <input type="date" id="date_envoi_mail_debut"
                                                   name="date_envoi_mail_debut" class="form-control"
                                                   @if($filters) value="{{ $filters['date_envoi_mail_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_envoi_mail_fin" class="form-label">Date fin</label>
                                            <input type="date" id="date_envoi_mail_fin" name="date_envoi_mail_fin"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_envoi_mail_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_envoi_mail_null[]" value="sans_valeur" @if($filters && isset($filters['date_envoi_mail_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-6">
                            <h4 class="text-center mb-4"
                                style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Info Empreinte</h4>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date d'empreinte
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_empreinte_debut" class="form-label">Date début</label>
                                            <input type="date" id="date_empreinte_debut" name="date_empreinte_debut"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_empreinte_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_empreinte_fin" class="form-label">Date fin</label>
                                            <input type="date" id="date_empreinte_fin" name="date_empreinte_fin"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_empreinte_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_empreinte_null[]" value="sans_valeur" @if($filters && isset($filters['date_empreinte_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date d'envoi au labo
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_envoi_labo_debut" class="form-label">Date début</label>
                                            <input type="date" id="date_envoi_labo_debut"
                                                   name="date_envoi_labo_debut" class="form-control"
                                                   @if($filters) value="{{ $filters['date_envoi_labo_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_envoi_labo_fin" class="form-label">Date fin</label>
                                            <input type="date" id="date_envoi_labo_fin" name="date_envoi_labo_fin"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_envoi_labo_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_envoi_labo_null[]" value="sans_valeur" @if($filters && isset($filters['date_envoi_labo_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Non réglés
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="acte_non_regle[]" value="non_regle" @if($filters && isset($filters['non_regle'])) checked @endif>
                                            </label> Afficher que les non-réglés
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-6">
                            <h4 class="text-center mb-4"
                                style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Retour labo</h4>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date livraison
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_livraison_debut" class="form-label">Date début</label>
                                            <input type="date" id="date_livraison_debut" name="date_livraison_debut"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_livraison_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_livraison_fin" class="form-label">Date fin</label>
                                            <input type="date" id="date_livraison_fin" name="date_livraison_fin"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_livraison_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_livraison_null[]" value="sans_valeur" @if($filters && isset($filters['date_livraison_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        numero suivi colis de retour
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="numero_suivi" class="form-label">numero suivi colis de
                                                retour + société de livraison</label>
                                            <input type="text" id="numero_suivi" name="numero_suivi"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['numero_suivi'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="numero_suivi_null[]" value="sans_valeur" @if($filters && isset($filters['numero_suivi_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        N° Facture Labo
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="numero_facture_labo" class="form-label">N° Facture
                                                Labo</label>
                                            <input type="text" id="numero_facture_labo" name="numero_facture_labo"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['numero_facture_labo'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="numero_facture_null[]" value="sans_valeur" @if($filters && isset($filters['numero_facture_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-6">
                            <h4 class="text-center mb-4"
                                style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Pose</h4>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date de pose prévue
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_pose_prevue_debut" class="form-label">Date
                                                début</label>
                                            <input type="date" id="date_pose_prevue_debut"
                                                   name="date_pose_prevue_debut" class="form-control"
                                                   @if($filters) value="{{ $filters['date_pose_prevue_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_pose_prevue_fin" class="form-label">Date fin</label>
                                            <input type="date" id="date_pose_prevue_fin" name="date_pose_prevue_fin"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_pose_prevue_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_pose_prevue_null[]" value="sans_valeur" @if($filters && isset($filters['date_pose_prevue_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Statut
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach($pose_status as $ps)
                                            <li class="dropdown-item">
                                                <label>
                                                    <input type="checkbox" class="form-check-input"
                                                           name="id_pose_statuts[]" value="{{ $ps->id }}"
                                                           @if($filters && isset($filters['id_pose_statuts']) && in_array($ps->id, $filters['id_pose_statuts']))
                                                               checked
                                                        @endif
                                                    >
                                                </label>
                                                {{ $ps->travaux_status }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-6">
                            <h4 class="text-center mb-4"
                                style="font-size: 24px; color: #2f8ab9; font-weight: bold;">Travaux cloture</h4>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date de pose réel
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_pose_reel_debut" class="form-label">Date début</label>
                                            <input type="date" id="date_pose_reel_debut" name="date_pose_reel_debut"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_pose_reel_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_pose_reel_fin" class="form-label">Date fin</label>
                                            <input type="date" id="date_pose_reel_fin" name="date_pose_reel_fin"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_pose_reel_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_pose_reel_null[]" value="sans_valeur" @if($filters && isset($filters['date_pose_reel_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Montant encaissé
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="montant_encaisse_min" class="form-label">Montant min</label>
                                            <input type="number" step="1" id="montant_encaisse_min"
                                                   name="montant_encaisse_min" class="form-control"
                                                   @if($filters) value="{{ $filters['montant_encaisse_min'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="montant_encaisse_max" class="form-label">Montant max</label>
                                            <input type="number" step="1" id="montant_encaisse_max"
                                                   name="montant_encaisse_max" class="form-control"
                                                   @if($filters) value="{{ $filters['montant_encaisse_max'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="montant_encaisse_null[]" value="sans_valeur" @if($filters && isset($filters['montant_encaisse_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        date controle paiement
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_controle_paiement_debut" class="form-label">Date
                                                début</label>
                                            <input type="date" id="date_controle_paiement_debut"
                                                   name="date_controle_paiement_debut" class="form-control"
                                                   @if($filters) value="{{ $filters['date_controle_paiement_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_controle_paiement_fin" class="form-label">Date
                                                fin</label>
                                            <input type="date" id="date_controle_paiement_fin"
                                                   name="date_controle_paiement_fin" class="form-control"
                                                   @if($filters) value="{{ $filters['date_controle_paiement_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_controle_paiement_null[]" value="sans_valeur" @if($filters && isset($filters['date_controle_paiement_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <h4 class="text-center mb-4"
                                style="font-size: 24px; color: #2f8ab9; font-weight: bold;">INFO CHEQUES</h4>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Numéro de chèque
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="numero_cheque" class="form-label">Numéro de chèque</label>
                                            <input type="text" id="numero_cheque" name="numero_cheque"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['numero_cheque'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="numero_cheque_null[]" value="sans_valeur" @if($filters && isset($filters['numero_cheque_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Montant du chèque
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="montant_cheque_min" class="form-label">Montant min</label>
                                            <input type="number" step="0.01" id="montant_cheque_min"
                                                   name="montant_cheque_min" class="form-control"
                                                   @if($filters) value="{{ $filters['montant_cheque_min'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="montant_cheque_max" class="form-label">Montant max</label>
                                            <input type="number" step="0.01" id="montant_cheque_max"
                                                   name="montant_cheque_max" class="form-control"
                                                   @if($filters) value="{{ $filters['montant_cheque_max'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="montant_cheque_null[]" value="sans_valeur" @if($filters && isset($filters['montant_cheque_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date d'encaissement chq
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_encaissement_cheque_debut" class="form-label">Date
                                                début</label>
                                            <input type="date" id="date_encaissement_cheque_debut"
                                                   name=date_encaissement_cheque_debut" class="form-control"
                                                   @if($filters) value="{{ $filters['date_encaissement_cheque_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_encaissement_cheque_fin" class="form-label">Date
                                                fin</label>
                                            <input type="date" id="date_encaissement_cheque_fin"
                                                   name=date_encaissement_cheque_fin" class="form-control"
                                                   @if($filters) value="{{ $filters['date_encaissement_cheque_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_encaissement_cheque_null[]" value="sans_valeur" @if($filters && isset($filters['date_encaissement_cheque_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Date de 1er L'acte
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">
                                            <label for="date_1er_acte_debut" class="form-label">Date début</label>
                                            <input type="date" id="date_1er_acte_debut" name="date_1er_acte_debut"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_1er_acte_debut'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label for="date_1er_acte_fin" class="form-label">Date début</label>
                                            <input type="date" id="date_1er_acte_fin" name="date_1er_acte_fin"
                                                   class="form-control"
                                                   @if($filters) value="{{ $filters['date_1er_acte_fin'] }}" @endif>
                                        </li>
                                        <li class="dropdown-item">
                                            <label>
                                                <input type="checkbox" class="form-check-input"
                                                       name="date_1er_acte_null[]" value="sans_valeur" @if($filters && isset($filters['date_1er_acte_null'])) checked @endif>
                                            </label> Sans valeurs
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Nature du chèque
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach($nature_cheques as $nc)
                                            <li class="dropdown-item">
                                                <label>
                                                    <input type="checkbox" class="form-check-input"
                                                           name="nature_cheques[]" value="{{ $nc->nature_cheque }}"
                                                           @if($filters && isset($filters['nature_cheques']) && in_array($nc->nature_cheque, $filters['nature_cheques']))
                                                               checked
                                                        @endif
                                                    >
                                                </label>
                                                {{ $nc->nature_cheque }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Tavaux Sur le Devis
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach($travaux_sur_devis as $tsd)
                                            <li class="dropdown-item">
                                                <label>
                                                    <input type="checkbox" class="form-check-input"
                                                           name="travaux_sur_devis[]"
                                                           value="{{ $tsd->travaux_sur_devis }}"
                                                           @if($filters && isset($filters['travaux_sur_devis']) && in_array($tsd->travaux_sur_devis, $filters['travaux_sur_devis']))
                                                               checked
                                                        @endif
                                                    >
                                                </label>
                                                {{ $tsd->travaux_sur_devis }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="color: whitesmoke; background-color: #2f8ab9;">
                                        Situation chèque
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach($situation_cheques as $sc)
                                            <li class="dropdown-item">
                                                <label>
                                                    <input type="checkbox" class="form-check-input"
                                                           name="situation_cheques[]"
                                                           value="{{ $sc->situation_cheque }}"
                                                           @if($filters && isset($filters['situation_cheques']) && in_array($sc->situation_cheque, $filters['situation_cheques']))
                                                               checked
                                                        @endif
                                                    >
                                                </label>
                                                {{ $sc->situation_cheque }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" style="color: whitesmoke">Rechercher</button>
                </form>
            </div>
        </div>
    </div>
</div>
