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
                                    @foreach($utilisateurs as $u)
                                        <tr>
                                            <td>{{ $u->code_u }}</td>
                                            <td>{{ $u->prenom }} {{ $u->nom }}</td>
                                            <td>
                                                <a href="{{ asset('effacer-utilisateur/'.$u->code_u ) }}">
                                                    <button type="button" class="btn btn-danger" onclick="showPasswordModal('{{ asset('effacer-utilisateur/'.$u->code_u ) }}')">
                                                        <i class="mdi mdi-delete"></i> Supprimer
                                                    </button>
                                                </a>
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
