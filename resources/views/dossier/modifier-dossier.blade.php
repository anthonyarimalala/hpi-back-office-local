@extends(session('layout') ?? 'layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Grand titre -->
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <h1 class="display-4">Modifier dossier</h1>
                    </div>
                </div>

                <form action="{{ route('modifier.dossier') }}" method="POST" class="forms-sample">
                    @csrf
                    <input name="dossier" value="{{ $v_dossier->dossier }}" hidden>
                    <div class="row">
                        <!-- Premier formulaire -->
                        <div class="col-lg-6">
                            <div class="card shadow-sm p-4">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card-body">
                                        <h4 class="card-title">Patient</h4>

                                        <div class="form-group">
                                            <label for="nom">Nom</label>
                                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="{{ $v_dossier->nom }}" disabled>
                                            @error('nom')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="date_naissance">Date naissance</label>
                                            <input type="date" class="form-control" id="date_naissance" name="date_naissance" placeholder="Date de naissance" value="{{ $v_dossier->date_naissance }}" disabled>
                                            @error('date_naissance')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Deuxième formulaire -->
                        <div class="col-lg-6">
                            <div class="card shadow-sm p-4">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card-body">
                                        <h4 class="card-title">Dossier</h4>
                                        <div class="form-group">
                                            <label for="dossier">Dossier</label>
                                            <input type="text" class="form-control" id="dossier" name="dossier" placeholder="Dossier" value="{{ $v_dossier->dossier }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                @foreach($statuss as $status)
                                                    @if($status->status == $v_dossier->status)
                                                        <option value="{{ $status->status }}">{{ $status->status }}</option>
                                                    @endif
                                                @endforeach
                                                @foreach($statuss as $status)
                                                    @if($status->status != $v_dossier->status)
                                                        <option value="{{ $status->status }}">{{ $status->status }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>


                                        <!-- Conteneur pour les mutuelles ajoutées -->
                                        <div id="mutuellesContainer">
                                            <label for="mutuelle">Mutuelle </label>
                                            @foreach($dossier_muts as $mut)
                                                <input type="text" id="mutuelle" class="form-control" value="{{ $mut->mutuelle }}" disabled>
                                                <a href="{{ asset('supprimer-mutuelle/'.$v_dossier->dossier.'/'.$mut->mutuelle) }}" class="btn btn-danger mt-2">Enlever</a>
                                            @endforeach
                                        </div>

                                        <!-- Bouton + pour ajouter une mutuelle -->
                                        <div class="form-group">
                                            <button type="button" class="btn btn-link" id="addMutuelleBtn">+ Ajouter une mutuelle</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton Ajouter -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg" style="color: whitesmoke">Mettre à jour</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script JavaScript pour gérer les mutuelles dynamiquement -->
    <script>
        document.getElementById('addMutuelleBtn').addEventListener('click', function() {
            // Créer un nouveau div pour le champ Mutuelle
            var mutuelleDiv = document.createElement('div');
            mutuelleDiv.classList.add('form-group');


            // Créer le champ input
            var input = document.createElement('input');
            input.type = 'text';
            input.classList.add('form-control');
            input.name = 'mutuelle[]';
            input.placeholder = 'Mutuelle';
            mutuelleDiv.appendChild(input);

            // Créer le bouton d'enlever
            var removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.classList.add('btn', 'btn-danger', 'mt-2');
            removeBtn.textContent = 'Enlever';
            removeBtn.addEventListener('click', function() {
                mutuelleDiv.remove();
            });
            mutuelleDiv.appendChild(removeBtn);

            // Ajouter le nouveau champ dans le conteneur
            document.getElementById('mutuellesContainer').appendChild(mutuelleDiv);
        });
    </script>
@endsection
