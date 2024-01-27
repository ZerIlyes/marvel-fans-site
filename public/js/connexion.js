 $(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault(); // Empêcher la soumission standard du formulaire
        var data = $(this).serialize(); // Sérialiser les données du formulaire

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: data,
            dataType: "json", // S'attendre à une réponse JSON
            success: function(response) {
                if(response.error) {
                    // Afficher l'erreur dans le modal
                    $('.alert').remove(); // Supprime les alertes précédentes
                    $('.modal-body').prepend('<div class="alert alert-danger">' + response.message + '</div>');
                } else {
                    // Si la connexion est réussie, vous pouvez rediriger ici avec JavaScript
                    window.location.href = 'index.php?action=menu'; // Redirigez vers le carrousel
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Une erreur est survenue: ", textStatus, errorThrown);
                console.log("Réponse du serveur: ", jqXHR.responseText); // Cela affichera la réponse du serveur, utile pour le débogage
            }
        });
    });
});
