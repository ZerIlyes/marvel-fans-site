<!-- Modal -->
<div class="modal" id="addUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="index.php?action=add_user" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un nouvel utilisateur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur :</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar :</label>
                        <select name="avatar" id="avatar" class="form-control" required>
                            <option value="public/images/Captainamerica.png">Captain</option>
                            <option value="public/images/Deadpool.png">Deadpool</option>
                            <option value="public/images/Ironman.png">Iron man</option>
                            <option value="public/images/spiderman.png">Spiderman</option>
                            <option value="public/images/Venom.png">Venom</option>
                            <option value="public/images/Wolverine.png">Wolverine</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>
