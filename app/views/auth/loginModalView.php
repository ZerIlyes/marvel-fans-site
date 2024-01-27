<!-- Modal de connexion -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Se connecter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex">
                <!-- Section d'erreur -->
                <div class="login-illustration">
                    <img src="public/images/Image-connexion.png" alt="Connexion" style="max-width:50%;height:auto;">
                </div>
                <div class="login-form">
                    <form id="loginForm" method="post" action="index.php?action=login" >
                        <div class="form-group">
                            <?php if(isset($_SESSION['login_error'])): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $_SESSION['login_error']; ?>
                                </div>
                                <?php unset($_SESSION['login_error']); endif; ?>
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="remember-me">
                            <label class="form-check-label" for="remember-me">Se souvenir de moi</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </form>
                    <div class="login-help">
                        <a href="#">Mot de passe oublié?</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="login-register">
                    Vous n'avez pas de compte? <a href="index.php?action=show_register">Inscrivez-vous</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="public/js/connexion.js"></script>
