<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
<!-- Les liens de navigation ici... -->

<!-- Modal d'inscription -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signupModalLabel">Inscription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="index.php?action=register">
                    <div class="form-group">
                        <label for="avatar">Choisissez votre avatar :</label>
                        <select name="avatar" id="avatar" class="form-control" required>
                            <option value="public/images/Captainamerica.png">Captain</option>
                            <option value="public/images/Deadpool.png">Deadpool</option>
                            <option value="public/images/Ironman.png">Iron man</option>
                            <option value="public/images/spiderman.png">Spiderman</option>
                            <option value="public/images/Venom.png">Venom</option>
                            <option value="public/images/Wolverine.png">Wolverine</option>
                            <!-- Ajoutez les autres options d'avatar ici -->
                        </select>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <img id="selectedAvatar" src="public/images/Captainamerica.png" alt="Selected Avatar" width="128" height="128">
                    </div>
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Nom d'utilisateur" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                    </div>
                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Fonction pour mettre à jour l'image de l'avatar en fonction de la sélection de l'utilisateur
    $('#avatar').change(function() {
        var selectedAvatar = $(this).val();
        $('#selectedAvatar').attr('src', selectedAvatar);
    });
</script>



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>


</body>
</html>