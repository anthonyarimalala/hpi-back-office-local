@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-6 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="card-title card-title-dash mb-0">Liste des utilisateurs</h4>
                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->has('password_confirmation'))
                                    <div class="alert alert-danger mt-2" role="alert">
                                        {{ $errors->first('password_confirmation') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="searchInput1" class="form-label"></label>
                                <input type="text" id="searchInput1" onkeyup="searchTable('searchInput1', 'myTable')" placeholder="Rechercher..." class="form-control">
                            </div>

                            <div class="table-responsive mt-1">
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                    <tr>
                                        <th class="infoCheques">Code</th>
                                        <th>Utilisateur</th>
                                        <th>Action <span id="sort-icon-0" class="mdi mdi-sort"></span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $code_u = \Illuminate\Support\Facades\Auth::user()->code_u;
                                    @endphp
                                    @foreach($utilisateurs as $u)

                                        <tr>
                                            <td>{{ $u->code_u }}</td>
                                            <td>{{ $u->prenom }} {{ $u->nom }} <br> {{ $u->role }} </td>

                                            <td>
                                                @if($u->code_u != $code_u)
                                                    <a href="#" class="open-modal"
                                                       data-nom="{{ $u->nom }}"
                                                       data-code_u="{{ $u->code_u }}"
                                                       data-role="{{ $u->role }}"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#deleteModal">
                                                        <button type="button" class="btn btn-danger">
                                                            <i class="mdi mdi-delete"></i> Supprimer
                                                        </button>
                                                    </a>
                                                    <a href="#" class="open-modal"
                                                       data-nom="{{ $u->nom }}"
                                                       data-code_u="{{ $u->code_u }}"
                                                       data-role="{{ $u->role }}"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#dateModal">
                                                        <button type="button" class="btn btn-primary">
                                                            <i class="mdi mdi-pen"></i> Modifier
                                                        </button>
                                                    </a>
                                                @endif
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

        <div class="col-lg-6 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <h4 class="card-title card-title-dash mb-0">Créer un utilisateur</h4>
                            <form action="{{ asset('creer-utilisateur') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="prenom" class="form-label">Prénom</label>
                                    <input type="text" name="prenom" id="prenom" class="form-control" required>
                                    @error('prenom')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input type="text" name="nom" id="nom" class="form-control" required>
                                    @error('nom')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmation de Mot De Passe</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Créer</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Supprimer un utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ asset('effacer-utilisateur/default') }}" id="deleteForm" method="GET">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Code utilisateur :</strong> <span id="userCode"></span><br>
                                <strong>Nom :</strong> <span id="userName"></span>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Mot de passe de confirmation</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" id="deleteBtn">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateModalLabel">Modifier un rôle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ asset('update-utilisateur/default') }}" id="exportForm" method="GET">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Code utilisateur :</strong> <span id="userCode"></span><br>
                                <strong>Nom :</strong> <span id="userName"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Rôle de l'utilisateur</label>
                                <select class="form-select" id="userRole" name="role">
                                    <option value="admin">Admin</option>
                                    <option value="user">Utilisateur</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Mot de passe de confirmation</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" id="exportBtn">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".open-modal").forEach(button => {
                button.addEventListener("click", function() {
                    // Récupérer les valeurs data-nom et data-code
                    let nom = this.getAttribute("data-nom");
                    let code_u = this.getAttribute("data-code_u");
                    let role = this.getAttribute("data-role");

                    // Insérer les valeurs dans le modal

                    document.querySelector("#userCode").innerText = code_u;
                    document.querySelector("#userName").innerText = nom;
                    // Mettre à jour le <select>
                    let selectRole = document.querySelector("#userRole");
                    if (selectRole) {
                        selectRole.value = role; // Sélectionne la bonne option
                    }

                    // Mettre à jour l'action du formulaire avec le rôle dynamique
                    let form = document.querySelector("#exportForm");
                    if (form) {
                        form.action = "{{ asset('update-utilisateur') }}/" + code_u;
                    }

                    let deleteForm = document.querySelector("#deleteForm");
                    if (deleteForm) {
                        deleteForm.action = "{{ asset('effacer-utilisateur/') }}/" + code_u;
                    }
                });
            });
        });
    </script>
    <script>
        function searchTable(inputId, tableId) {
            const input = document.getElementById(inputId);
            const filter = input.value.toLowerCase();
            const table = document.getElementById(tableId);
            const rows = table.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');

                if (cells.length > 0) {
                    let rowContainsFilter = false;

                    for (let j = 0; j < cells.length; j++) {
                        const cellContent = cells[j].textContent || cells[j].innerText;
                        if (cellContent.toLowerCase().includes(filter)) {
                            rowContainsFilter = true;
                            break;
                        }
                    }

                    row.style.display = rowContainsFilter ? '' : 'none';
                }
            }
        }
    </script>
@endsection
