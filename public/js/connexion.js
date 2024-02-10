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
                    window.location.href = response.redirect;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Une erreur est survenue: ", textStatus, errorThrown);
                console.log("Réponse du serveur: ", jqXHR.responseText);
            }
        });
    });
});
