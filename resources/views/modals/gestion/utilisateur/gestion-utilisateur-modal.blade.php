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

<div class="modal fade" id="modifRoleModal" tabindex="-1" aria-labelledby="modifRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifRoleModalLabel">Modifier un rôle</h5>
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
                                <option value="responsableCA">Responsable CA</option>
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
