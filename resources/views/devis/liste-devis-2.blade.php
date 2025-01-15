@extends(session('layout') ?? 'layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="card-title card-title-dash mb-0">Liste des devis</h4>
                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
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

                            <div class="table-responsive  mt-1">
                                <div class="d-flex justify-content-center">
                                    {{ $deviss->links('pagination::bootstrap-4') }}
                                </div>
                                <table class="table" id="myTable">
                                    <thead>
                                    <!-- Section INFO DEVIS -->
                                    <tr>
                                        <th colspan="6" style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">INFO DEVIS</th>
                                        <th colspan="4" style="background-color: #f8f9fa; text-align: center; border-right: 2px solid #000;">INFO ACCORD PEC</th>
                                        <th colspan="8" style="background-color: #f8f9fa; text-align: center;">APPELS & MAIL</th>
                                    </tr>
                                    <tr>
                                        <!-- INFO DEVIS -->
                                        <!-- triTableau(tableId, columnIndex, isText = true, isNumber = false, isDate = false) -->
                                        <!-- 0 -->
                                        <th onclick="sortTableByString('myTable', 0)">Dossier<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 1 -->
                                        <th onclick="sortTableByString('myTable', 1)">Patient<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 2 -->
                                        <th onclick="sortTableByDate('myTable', 2)">Date<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 3 -->
                                        <th onclick="sortTableByNumber('myTable', 3)">Montant<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 4 -->
                                        <th onclick="sortTableByString('myTable', 4)">Devis signé<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 5 -->
                                        <th onclick="sortTableByString('myTable', 5)" style="border-right: 2px solid #000;">Praticien<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- INFO ACCORD PEC -->
                                        <!-- 6 -->
                                        <th onclick="sortTableByDate('myTable', 6)">Date envoie PEC<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 7 -->
                                        <th onclick="sortTableByDate('myTable', 7)">Date fin validité PEC<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 8 -->
                                        <th onclick="sortTableByNumber('myTable', 8)">Part mutuelle<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 9 -->
                                        <th onclick="sortTableByNumber('myTable', 9)" style="border-right: 2px solid #000;">Part RAC<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- APPELS & MAIL -->
                                        <!-- 10 -->
                                        <th onclick="sortTableByDate('myTable', 10)">Date 1er appel<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 11 -->
                                        <th>Note 1er appel</th>
                                        <!-- 12 -->
                                        <th onclick="sortTableByDate('myTable', 12)">Date 2ème appel<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 13 -->
                                        <th>Note 2ème appel</th>
                                        <!-- 14 -->
                                        <th onclick="sortTableByDate('myTable', 14)">Date 3ème appel<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                        <!-- 15 -->
                                        <th>Note 3ème appel</th>
                                        <!-- 16 -->
                                        <th onclick="sortTableByDate('myTable', 16)">Date envoi mail<span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($deviss as $devis)
                                        <tr style="background-color: {{ $devis->couleur }};" onmouseover="this.style.backgroundColor='#d3d3d3';" onmouseout="this.style.backgroundColor='{{ $devis->couleur }}';">
                                            <!-- INFO DEVIS -->
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                <strong>{{ $devis->dossier }}</strong>
                                            </td>
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer; word-wrap: break-word; max-width: 150px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->nom }}
                                            </td>
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate() }}
                                            </td>
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getMontant() }}
                                            </td>
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                @if($devis->devis_signe == 'oui')
                                                    <label class="badge badge-info">Oui</label>
                                                @else
                                                    Non
                                                @endif
                                            </td>
                                            <td style="border-right: 2px solid #000;" onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->praticien }}
                                            </td>

                                            <!-- INFO ACCORD PEC -->
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_envoi_pec() }}
                                            </td>
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_fin_validite_pec() }}
                                            </td>
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getPart_mutuelle() }}
                                            </td>
                                            <td style="border-right: 2px solid #000;" onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getPart_rac() }}
                                            </td>

                                            <!-- APPELS & MAIL -->
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_1er_appel() }}
                                            </td>
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer; word-wrap: break-word; max-width: 175px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->getNote_1er_appel() }}
                                            </td>
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_2eme_appel() }}
                                            </td>
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer; word-wrap: break-word; max-width: 175px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->getNote_2eme_appel() }}
                                            </td>
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_3eme_appel() }}
                                            </td>
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer; word-wrap: break-word; max-width: 175px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $devis->getNote_3eme_appel() }}
                                            </td>
                                            <td onclick="window.location.href='{{ $devis->dossier }}/devis/{{ $devis->id_devis }}/detail';" style="cursor:pointer;">
                                                {{ $devis->getDate_envoi_mail() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    {{ $deviss->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
