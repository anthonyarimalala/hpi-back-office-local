<div class="modal fade" id="posestatusModal" tabindex="-1" aria-labelledby="posestatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="posestatusModalLabel">Sélectionner la période</h5>
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
                                                <h4 class="card-title card-title-dash">Liste des statuts</h4>
                                            </div>
                                        </div>
                                        <div class="mt-1">
                                            <ul class="list-group">
                                                @foreach($status_poses as $status)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6>{{ $status->travaux_status }}</h6>
                                                        </div>
                                                        <div class="d-flex">
                                                            <!-- Bouton Supprimer -->
                                                            <form action="{{ asset('delete-pose-status') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce statut ?');">
                                                                @csrf
                                                                <input id="id_status_pose" type="text" name="id_status_pose" value="{{ $status->id }}" hidden>
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
                                                <h4 class="card-title card-title-dash">Nouveau statut</h4>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Formulaire Ajouter un nouveau statut -->
                                    <form action="{{ asset('save-pose-status') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="status_pose" class="form-label">Status</label>
                                            <input type="text" class="form-control" id="status_pose" name="status_pose" required>
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
</div>

