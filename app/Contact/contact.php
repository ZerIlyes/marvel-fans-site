<?php
// Samir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Vérification des données
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Préparation de l'email
        $to = "marvel.fans.site@gmail.com";
        $subject = "Nouvelle demande de contact";
        $emailBody = "Nom: $name\nEmail: $email\nMessage: $message";

        // En-têtes pour l'email
        $headers = "De: $email";

        // Envoi de l'email
        if(mail($to, $subject, $emailBody, $headers)) {
            echo "Message envoyé avec succès.";
        } else {
            echo "Erreur lors de l'envoi du message.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2>Contact</h2>
            <p>Besoin d'aide ?  <span>Contactez Nous ! </span></p>
        </div>

        <div class="mb-3">
            <img style="border:0; width: 100%; height: 350px;" src="../../../public/images/strange.png">
        </div>


        <form action="https://formspree.io/f/mrgnejzb" method="POST">
            <label>
                Your email:
                <input type="email" name="email">
            </label>
            <label>
                Your message:
                <textarea name="message"></textarea>
            </label>
    </div>


    <div class="text-center"><button type="submit">ENVOYER</button></div>
    </form>
    </div>
</section>

<style>
    .contact .info-item {
        background: #f4f4f4;
        padding: 30px;
        height: 100%;
    }

    .contact .info-item .icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        font-size: 24px;
        line-height: 0;
        color: #fff;
        background: blue;
        border-radius: 50%;
        margin-right: 15px;
    }

    .contact .info-item h3 {
        font-size: 20px;
        color: #6c757d;
        font-weight: 700;
        margin: 0 0 5px 0;
    }

    .contact .info-item p {
        padding: 0;
        margin: 0;
        line-height: 24px;
        font-size: 14px;
    }

    .contact .info-item .social-links a {
        font-size: 24px;
        display: inline-block;
        color: rgba(55, 55, 63, 0.7);
        line-height: 1;
        margin: 4px 6px 0 0;
        transition: 0.3s;
    }

    .contact .info-item .social-links a:hover {
        color:blue;
    }

    .contact .php-email-form {
        width: 100%;
        margin-top: 30px;
        background: #fff;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
    }

    .contact .php-email-form .form-group {
        padding-bottom: 20px;
    }

    .contact .php-email-form .error-message {
        display: none;
        color: #fff;
        background: #df1529;
        text-align: left;
        padding: 15px;
        font-weight: 600;
    }

    .contact .php-email-form .error-message br+br {
        margin-top: 25px;
    }

    .contact .php-email-form .sent-message {
        display: none;
        color: #fff;
        background: #8dc63f;
        text-align: center;
        padding: 15px;
        font-weight: 600;
    }

    .contact .php-email-form .loading {
        display: none;
        background: #fff;
        text-align: center;
        padding: 15px;
    }

    .contact .php-email-form .loading:before {
        content: "";
        display: inline-block;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        margin: 0 10px -6px 0;
        border: 3px solid #8dc63f;
        border-top-color: #fff;
        animation: animate-loading 1s linear infinite;
    }

    .contact .php-email-form input,
    .contact .php-email-form textarea {
        border-radius: 0;
        box-shadow: none;
        font-size: 14px;
    }

    .contact .php-email-form input:focus,
    .contact .php-email-form textarea:focus {
        border-color: black;
    }

    .contact .php-email-form input {
        height: 48px;
    }

    .contact .php-email-form textarea {
        padding: 10px 12px;
    }

    .contact .php-email-form button[type=submit] {
        background: blue;
        border: 0;
        padding: 12px 40px;
        color: #fff;
        transition: 0.4s;
        border-radius: 50px;
    }

    .contact .php-email-form button[type=submit]:hover {
        background: #41690a;
    }

    @keyframes animate-loading {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

