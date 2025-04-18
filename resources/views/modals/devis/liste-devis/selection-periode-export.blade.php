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
                            <input type="date" id="date_devis_debut" name="date_devis_debut" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_devis_fin" class="form-label">Date fin</label>
                            <input type="date" id="date_devis_fin" name="date_devis_fin" class="form-control">
                        </div>
                        <div class="col-md-12 mb-12">
                            <div>
                                <input type="checkbox" id="withFilters" name="withFilters[]" value="oui">
                                <label for="withFilters">Prendre en compte les filtres</label>
                            </div>
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
