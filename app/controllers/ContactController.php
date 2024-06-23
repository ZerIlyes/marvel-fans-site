<?php
class ContactController {
    public function showForm() {
        include 'views/contact.php';
    }

    public function submitForm() {
        // Traitement du formulaire
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        // Valider les données
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Email invalide";
            include 'views/contact.php';
            return;
        }

        // Envoyer le message par email
        $to = 'support@fansdecomics.com';
        $subject = 'Nouveau message de contact';
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $body = "Nom: $name\nEmail: $email\nMessage:\n$message";

        if (mail($to, $subject, $body, $headers)) {
            include 'views/contact_success.php';
        } else {
            $error = "Échec de l'envoi du message. Veuillez réessayer.";
            include 'views/contact.php';
        }
    }
}
?>