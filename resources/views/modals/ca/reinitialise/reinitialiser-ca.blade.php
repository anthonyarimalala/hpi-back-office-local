<div class="modal fade" id="reinitialiseCAModal" tabindex="-1" aria-labelledby="reinitialiseCAModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel">Supprimer devis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="importForm" action="{{ asset('reinitialiser-ca/1') }}" method="GET" class="forms-sample"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_ca_create_debut" class="form-label">Date début</label>
                            <input type="date" id="date_ca_create_debut" name="date_ca_create_debut" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_ca_create_fin" class="form-label">Date fin</label>
                            <input type="date" id="date_ca_create_fin" name="date_ca_create_fin" class="form-control">
                        </div>
                        <div class="col-md-12 mb-12">
                            <div>
                                <input type="checkbox" id="withFilters" name="withFilters[]" value="oui" checked>
                                <label for="withFilters">Prendre en compte les filtres</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-12">
                            <label for="devisFile">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" accept=".xlsx">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="exportBtn">Supprimer</button>
                </div>
            </form>

        </div>
    </div>
</div>
