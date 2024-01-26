<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Jarvis - Site Communautaire de Comics</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="public/css/jarvis.css">
</head>
<body>
<div class="bg-image"></div>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="chat-interface card">
                <div class="card-body">
                    <h1 class="card-title text-center">J.A.R.V.I.S</h1>
                    <p class="text-center">L'IA d'Iron Man à votre service</p>
                    <div id="chat-container" class="mb-3">
                        <!-- Les réponses de Jarvis apparaîtront ici -->
                    </div>
                    <textarea id="user-input" class="form-control mb-3" placeholder="Posez-moi une question..."></textarea>
                    <button id="send-button" class="btn btn-primary btn-block">Envoyer</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="public/js/jarvis.js"></script>
<script type="text/javascript">
    var userAvatarPath = <?php echo json_encode($userAvatarPath); ?>;
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
    var userAvatarPath = <?php echo json_encode($userAvatarPath); ?>;
</script>
</body>
</html>
