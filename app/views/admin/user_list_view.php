<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Utilisateurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="public/js/js.js"></script>
    <link rel="stylesheet" href="public/css/redirection.css">
    <?php include 'public/redirection.php'; ?>
</head>
<body>
<?php include 'app/views/admin/add_user_modal.php'; ?>
<div class="container mt-4">
    <h2>Liste des Utilisateurs</h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID Utilisateur</th>
            <th>Nom d'utilisateur</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user):  ?>
            <tr id="userRow<?php echo $user['user_id']; ?>">
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td>
                    <button class="btn btn-danger" onclick="deleteUser(<?php echo $user['user_id']; ?>)">Supprimer</button>
                    <a class="btn btn-info" href="index.php?action=view_user_topics&user_id=<?php echo $user['user_id']; ?>">Voir les sujets</a>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
        Ajouter un nouvel utilisateur
    </button>
</div>





<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
