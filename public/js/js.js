
    function deleteTopic(topicId) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce sujet ?")) {
    $.ajax({
    url: 'index.php?action=delete_topic',
    type: 'POST',
    data: { topic_id: topicId },
    success: function(response) {
    var data = JSON.parse(response);
    if (data.success) {
    $('#topicRow' + topicId).remove();
} else {
    alert(data.message);
}
}
});
}
}


    $(document).ready(function() {
        $('#addUserForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: 'index.php?action=add_user',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        $('#addUserModal').modal('hide');
                        // Ajoutez l'utilisateur à la table sans recharger la page...
                    } else {
                        alert(data.message);
                    }
                }
            });
        });
    });

    $(document).ready(function() {
        $('#addUserForm').on('submit', function(e) {
            e.preventDefault(); // Empêcher le formulaire de se soumettre normalement

            var formData = $(this).serialize(); // Récupérer les données du formulaire

            $.ajax({
                url: 'index.php?action=add_user', // URL du contrôleur qui gère l'ajout
                type: 'POST',
                data: formData,
                success: function(response) {
                    try {
                        var data = JSON.parse(response);
                        if (data.success) {
                            // Ajoutez ici le code pour ajouter l'utilisateur dans la liste sur la page
                            // Fermez le modal
                            $('#addUserModal').modal('hide');
                        } else {
                            // Affichez une alerte avec le message d'erreur
                            alert(data.message);
                        }
                    } catch (e) {
                        // Affichez une alerte en cas d'erreur de réponse du serveur
                        alert('Erreur lors du traitement de la réponse du serveur.');
                    }
                },
                error: function() {
                    // Affichez une alerte en cas d'erreur AJAX
                    alert('Erreur lors de la soumission du formulaire.');
                }
            });
        });
    });
    function deleteUser(userId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
            $.ajax({
                url: 'index.php?action=delete_user', // Assurez-vous que cette URL est correcte
                type: 'POST',
                data: { user_id: userId },
                dataType: 'json', // S'assurer que la réponse est attendue en JSON
                success: function(response) {
                    if(response.success) {
                        $('#userRow' + userId).remove();
                    } else {
                        alert("Erreur : " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert("Une erreur est survenue: " + error);
                }
            });
        }
    }