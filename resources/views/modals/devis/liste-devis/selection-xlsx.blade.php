<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel">Sélectionner un fichier .xslx</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="importForm" action="{{ asset('devis/import') }}" method="POST" class="forms-sample"
                  enctype="multipart/form-data">
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
