<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Jeu 2D</title>

    <img id="doorTopLeft" class="door" src="public/images/porte1.png">
    <img src="public/images/jarviis.png" class="ecriture" id="ecritureTopLeft">

    <img id="doorTopRight" class="door" src="public/images/porte1.png">
    <img src="public/images/quizz.png" class="ecriture" id="ecritureTopRight">

    <img id="doorBottomLeft" class="door" src="public/images/porte1.png">
    <img src="public/images/revieww.png" class="ecriture" id="ecritureBottomLeft">

    <img id="doorBottomRight" class="door" src="public/images/porte1.png">
    <img src="public/images/forum.png" class="ecriture" id="ecritureBottomRight">

    <div class="popup" id="popupTopLeft">
        <div class="popup-content">
            <h2>Bienvenue sur la page Jarvis</h2>
            <p>Êtes-vous prêt à entrer dans la page Jarvis ?</p>
            <button onclick="enterPage('jarvis')">Entrer</button>
            <button onclick="closePopup('popupTopLeft')">Annuler</button>
        </div>
    </div>

    <div class="popup" id="popupTopRight">
        <div class="popup-content">
            <h2>Bienvenue sur la page Quizz</h2>
            <p>Êtes-vous prêt à entrer dans la page Quizz ?</p>
            <button onclick="enterPage('quizz')">Entrer</button>
            <button onclick="closePopup('popupTopRight')">Annuler</button>
        </div>
    </div>

    <div class="popup" id="popupBottomLeft">
        <div class="popup-content">
            <h2>Bienvenue sur la page Review</h2>
            <p>Êtes-vous prêt à entrer dans la page Review ?</p>
            <button onclick="enterPage('review')">Entrer</button>
            <button onclick="closePopup('popupBottomLeft')">Annuler</button>
        </div>
    </div>

    <div class="popup" id="popupBottomRight">
        <div class="popup-content">
            <h2>Bienvenue sur la page Forums</h2>
            <p>Êtes-vous prêt à entrer dans la page Forums ?</p>
            <button onclick="enterPage('forums')">Entrer</button>
            <button onclick="closePopup('popupBottomRight')">Annuler</button>
        </div>
    </div>
    <div class="popup" id="confirmationPopup">
        <div  class="popup-content">
            <h2>Confirmation</h2>
            <p>Êtes-vous sûr de vouloir entrer dans la page <span id="pageName"></span> ?</p>
            <button onclick="confirmPageEntry()">Oui</button>
            <button onclick="closeConfirmationPopup()">Annuler</button>
        </div>
    </div>


    <style>
        body {
            margin: 0;
            overflow: hidden;
            background-image: url('public/images/Background_jeu.png'); /* Assurez-vous d'utiliser le bon chemin vers votre image d'herbe verte */
            background-size: cover; /* Ajuste la taille de l'image pour couvrir toute la fenêtre */
            background-repeat: no-repeat; /* Empêche la répétition de l'image de fond */
        }
        canvas {
            border: 1px solid #000;
            display: block;
        }
        #chat-container {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Fond semi-transparent */
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            border-radius: 5px; /* Coins arrondis */
        }
        #chat-messages {
            max-height: 200px;
            overflow-y: scroll;
            padding: 5px;
        }
        #message-input {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .door {
            position: absolute;
            width: 180px; /* Taille de la porte */
            height: 160px; /* Taille de la porte */
        }

        #doorTopLeft {
            top: 23px;
            left: 100px;
        }

        #doorTopRight {
            top: 23px;
            right: 100px;
        }

        #doorBottomLeft {
            bottom: 23px;
            left:100px;
        }

        #doorBottomRight {
            bottom: 23px;
            right: 100px;
        }

        .ecriture {
            position: absolute;
            width: 100px; /* Ajustez la largeur selon vos besoins */
            height: 50px; /* Ajustez la hauteur selon vos besoins */
        }

        #ecritureTopLeft {
            top: 200px; /* Ajustez la position verticale */
            left: 130px; /* Ajustez la position horizontale */
        }

        #ecritureTopRight {
            top: 200px; /* Ajustez la position verticale */
            right: 150px; /* Ajustez la position horizontale */
        }

        #ecritureBottomLeft {
            bottom: 200px; /* Ajustez la position verticale */
            left: 130px; /* Ajustez la position horizontale */
        }

        #ecritureBottomRight {
            bottom: 200px; /* Ajustez la position verticale */
            right: 150px; /* Ajustez la position horizontale */
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .popup-content {
            text-align: center;
        }

        .popup button {
            margin: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

    </style>
</head>
<body>
<canvas id="myCanvas"></canvas>

<div id="chat-container">
    <div id="chat-messages"></div>
    <input type="text" id="message-input" placeholder="Tapez votre message ici...">
</div>

<script>
    const canvas = document.getElementById('myCanvas');
    const context = canvas.getContext('2d');

    const canvasWidth = window.innerWidth;
    const canvasHeight = window.innerHeight;
    canvas.width = canvasWidth;
    canvas.height = canvasHeight;

    // Charger les images pour chaque direction
    const bonhommeLeft = new Image();
    bonhommeLeft.src = 'public/images/Left.png';

    const bonhommeRight = new Image();
    bonhommeRight.src = 'public/images/Right.png';

    const bonhommeFront = new Image();
    bonhommeFront.src = 'public/images/Front.png';

    const bonhommeBack = new Image();
    bonhommeBack.src = 'public/images/Back.png';

    const bonhomme = {
        x: canvasWidth / 2,
        y: canvasHeight / 2,
        image: bonhommeFront,
        largeur: 100,
        hauteur: 150,
        vitesse: 5
    };

    const doors = {
        topLeft: { x: 100, y: 100, element: document.getElementById('doorTopLeft') },
        topRight: { x: canvasWidth - 100, y: 100, element: document.getElementById('doorTopRight') },
        bottomLeft: { x: 100, y: canvasHeight - 100, element: document.getElementById('doorBottomLeft') },
        bottomRight: { x: canvasWidth - 100, y: canvasHeight - 100, element: document.getElementById('doorBottomRight') }
    };

    function calculateDistance(bonhomme, door) {
        const dx = bonhomme.x - door.x;
        const dy = bonhomme.y - door.y;
        return Math.sqrt(dx * dx + dy * dy);
    }

    function updateDoorImage(door, distance) {
        // Mise à jour des images de porte en fonction de la distance
        if (distance < 250) {
            door.element.src = 'public/images/porte4.png';
        } else if (distance < 300) {
            door.element.src = 'public/images/porte3.png';
        } else if (distance < 320) {
            door.element.src = 'public/images/porte2.png';
        } else {
            door.element.src = 'public/images/porte1.png';
        }
    }

    function drawBonhomme() {
        context.drawImage(bonhomme.image, bonhomme.x - bonhomme.largeur / 2, bonhomme.y - bonhomme.hauteur / 2, bonhomme.largeur, bonhomme.hauteur);
    }

    function update() {
        let newX = bonhomme.x;
        let newY = bonhomme.y;

        if (keys['ArrowLeft']) {
            bonhomme.image = bonhommeLeft;
            newX -= bonhomme.vitesse;
        }
        if (keys['ArrowRight']) {
            bonhomme.image = bonhommeRight;
            newX += bonhomme.vitesse;
        }
        if (keys['ArrowUp']) {
            bonhomme.image = bonhommeBack;
            newY -= bonhomme.vitesse;
        }
        if (keys['ArrowDown']) {
            bonhomme.image = bonhommeFront;
            newY += bonhomme.vitesse;
        }

        newX = Math.max(0, Math.min(newX, canvasWidth - bonhomme.largeur));
        newY = Math.max(0, Math.min(newY, canvasHeight - bonhomme.hauteur));

        let canMove = true;
        Object.values(doors).forEach(door => {
            const distance = calculateDistance({ x: newX, y: newY }, door);
            updateDoorImage(door, distance);

            if (distance < 250) {
                redirectToPage(door); // Redirection si le personnage est proche de la porte
                canMove = false; // Empêcher le mouvement du personnage
            }
        });

        if (canMove) {
            bonhomme.x = newX;
            bonhomme.y = newY;
        }

        context.clearRect(0, 0, canvasWidth, canvasHeight);
        drawBonhomme();

        requestAnimationFrame(update);
    }

    // Fonction de redirection
    function redirectToPage(door) {
        if (door === doors.topLeft) {
            window.location.href = 'app/views/jarvis/jarvis_view.php';
        } else if (door === doors.topRight) {
            window.location.href = 'app/views/quiz/quiz_list_view.php';
        } else if (door === doors.bottomLeft) {
            window.location.href = 'app/views/review/write_review_view.php';
        } else if (door === doors.bottomRight) {
            window.location.href = 'app/views/forum/forum_view.php';
        }
    }

    const keys = {};

    document.addEventListener('keydown', (event) => {
        keys[event.key] = true;
    });

    document.addEventListener('keyup', (event) => {
        keys[event.key] = false;
    });

    update();
</script>

</body>
</html>