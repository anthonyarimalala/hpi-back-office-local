<div class="modal fade" id="praticienModal" tabindex="-1" aria-labelledby="praticienModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="praticienModalLabel">Sélectionner la période</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column">
                        <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card card-rounded">
                                    <div class="card-body">
                                        <div class="d-sm-flex justify-content-between align-items-start">
                                            <div>
                                                <h4 class="card-title card-title-dash">Liste des praticiens</h4>
                                            </div>
                                        </div>
                                        <div class="mt-1">
                                            <ul class="list-group">
                                                @foreach($praticiens as $p)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6>{{ $p->praticien }}</h6>
                                                            <p>{{ $p->nom }}</p>
                                                        </div>
                                                        <div class="d-flex">
                                                            <!-- Bouton Supprimer -->
                                                            <form action="{{ asset('delete-praticien') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce praticien ?');">
                                                                @csrf
                                                                <label for="praticien"></label>
                                                                <input id="praticien" type="text" name="praticien" value="{{ $p->praticien }}" hidden>
                                                                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                                    <i class="mdi mdi-delete"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex flex-column">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h4 class="card-title card-title-dash">Nouveau praticien</h4>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Formulaire Ajouter un nouveau praticien -->
                                    <form action="{{ asset('save-praticien') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="praticien" class="form-label">Praticien</label>
                                            <input type="text" class="form-control" id="praticien" name="praticien" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nom" class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="nom" name="nom">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Ajouter le praticien</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

