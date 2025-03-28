<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Sélectionner la période</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Liste des statuts -->
                    <div class="col-lg-6 mb-4">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <h4 class="card-title">Liste des statuts</h4>
                                <ul class="list-group">
                                    @foreach($statuss as $status)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6>{{ $status->status }}</h6>
                                                <p>{{ $status->signification }}</p>
                                            </div>
                                            <div class="d-flex">
                                                <!-- Bouton Supprimer -->
                                                <form action="{{ asset('delete-dossier-status') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce statut ?');">
                                                    @csrf
                                                    <input id="status" type="text" name="status" value="{{ $status->status }}" hidden>
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

                    <!-- Formulaire Ajouter un nouveau statut -->
                    <div class="col-lg-6">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <h4 class="card-title">Nouveau statut</h4>
                                <form action="{{ asset('save-dossier-status') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <input type="text" class="form-control" id="status" name="status" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="signification" class="form-label">Signification</label>
                                        <input type="text" class="form-control" id="signification" name="signification">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Ajouter le statut</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

