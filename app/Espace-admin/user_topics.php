<?php
require_once 'admin.php';
require_once '../config.php';

$user_id = $_GET["user_id"];
// Amgad.
// Récupérer les informations de l'utilisateur depuis la base de données
$user_query = $conn->query("SELECT username FROM users WHERE user_id = $user_id");
$user = $user_query->fetch_assoc();

$sql = "SELECT topics.topic_id, topics.title, topics.created_at
        FROM topics
        WHERE topics.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$user_topics = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <style>
        body {
            font-family:'Bangers', cursive;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            color: #888;
        }

        /* Style du bouton de suppression */
        button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Les sujets créés par <?= htmlspecialchars($user['username']) ?></h2>

    <?php if (empty($user_topics)): ?>
        <p>Cet utilisateur n'a créé aucun sujet.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($user_topics as $topic): ?>
                <li>
                    <a href="topic.php?id=<?= $topic['topic_id'] ?>">
                        <?= $topic['title'] ?>
                    </a>
                    - <?= $topic['created_at'] ?>

                    <!-- Ajouter le bouton de suppression -->
                    <form action="delete_topic.php" method="post" style="display: inline;">
                        <input type="hidden" name="topic_id" value="<?= $topic['topic_id'] ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<script>
    $(document).ready(function(){
        // Gérez la suppression avec AJAX
        $(".delete-btn").click(function(){
            var topic_id = $(this).data("topic-id");
            var user_id = $(this).data("user-id"); // Ajoutez cette ligne pour récupérer l'ID de l'utilisateur

            $.ajax({
                url: "delete_topic.php",
                type: "POST",
                data: { topic_id: topic_id },
                dataType: "json",
                success: function(response){
                    if (response.success) {
                        // Supprimez la ligne du sujet de la liste sans recharger la page
                        $("#topicRow" + topic_id).remove();
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        });
    });
</script>

</body>
</html>
