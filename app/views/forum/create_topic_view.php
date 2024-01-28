<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un sujet - Forum Comics</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/create_topic.css">
</head>
<body>

<div class="container my-5">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Créer un nouveau sujet</h1>
        </div>
        <div class="card-body">
            <form action="index.php?action=create_topic" method="post">
                <div class="form-group">
                    <label for="title">Titre du sujet :</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Créer</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
