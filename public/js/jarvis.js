// Initialiser l'historique des chats dans sessionStorage
if (!sessionStorage.getItem('chatHistory')) {
    sessionStorage.setItem('chatHistory', JSON.stringify([]));
}

// Écouteur d'événements pour le bouton d'envoi
document.getElementById('send-button').addEventListener('click', function() {
    var userInput = document.getElementById('user-input').value;
    if (userInput.trim() !== '') {
        getResponseFromGPT4(userInput);
    }
});

// Fonction pour envoyer la requête à l'API GPT et obtenir une réponse
function getResponseFromGPT4(query) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "https://api.openai.com/v1/chat/completions");
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.setRequestHeader("Authorization", "Bearer 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");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            var response = JSON.parse(xhr.responseText);
            if (response.error) {
                console.error("Erreur de l'API : ", response.error.message);
            } else {
                var jarvisResponse = response.choices[0].message.content;
                saveToSession(query, jarvisResponse);
                updateChatUI(query, jarvisResponse);
            }
            document.getElementById('send-button').disabled = false;
        }
    };

    document.getElementById('send-button').disabled = true;

    var sessionHistory = getSessionHistory();
    sessionHistory.push({role: "user", content: query});

    var data = JSON.stringify({
        model: "gpt-3.5-turbo",
        messages: initializeContext().concat(sessionHistory)
    });

    xhr.send(data);
}

function initializeContext() {
    // Prompt pour définir un contexte initial pour les conversations sur les comics DC et Marvel
    return [
        { role: "system", content: "Vous discutez avec Jarvis, un expert des comics de Marvel et DC. Jarvis est ici pour répondre à vos questions sur les comics et les univers de Marvel et DC. L'assistant se limitera à répondre aux questions sur ces univers." }
    ];
}

// Fonction pour sauvegarder la conversation dans sessionStorage
function saveToSession(userInput, jarvisResponse) {
    var chatHistory = getSessionHistory();
    chatHistory.push({role: "assistant", content: jarvisResponse});
    sessionStorage.setItem('chatHistory', JSON.stringify(chatHistory));
}

// Fonction pour récupérer l'historique de la session
function getSessionHistory() {
    return JSON.parse(sessionStorage.getItem('chatHistory')) || [];
}

function typeMessage(element, message, index, interval) {
    // Si l'index est inférieur à la longueur du message, ajouter le caractère suivant
    if (index < message.length) {
        // Ajouter le caractère actuel au contenu de l'élément
        element.textContent += message[index++];

        // Attendre un peu avant d'ajouter le prochain caractère
        setTimeout(function () {
            typeMessage(element, message, index, interval);
        }, interval);
    }
}

// Fonction pour mettre à jour l'interface utilisateur avec les messages
function updateChatUI(userInput, jarvisResponse) {
    var chatContainer = document.getElementById('chat-container');

    // Créer et ajouter le message de l'utilisateur
    var userMessageDiv = createChatMessage('Vous', userInput, userAvatarPath);
    chatContainer.appendChild(userMessageDiv);

    // Créer et ajouter la réponse de Jarvis lettre par lettre
    var jarvisMessageDiv = createChatMessage('Jarvis', '', 'public/images/jarvis.png'); // Assurez-vous que le chemin est correct
    chatContainer.appendChild(jarvisMessageDiv);

    // Commencer à taper le message de Jarvis
    typeMessage(jarvisMessageDiv.querySelector('p'), jarvisResponse, 0, 15); // 15 est l'intervalle en millisecondes

    // Réinitialiser le champ de saisie
    document.getElementById('user-input').value = '';
}

// Fonction pour créer un élément de message de chat
function createChatMessage(sender, text, avatarPath) {
    var messageDiv = document.createElement('div');
    messageDiv.className = 'chat-message ' + sender.toLowerCase() + '-message';

    var avatarImg = document.createElement('img');
    avatarImg.src = avatarPath;
    avatarImg.alt = sender + ' Avatar';
    avatarImg.className = 'avatar';

    var messageP = document.createElement('p');
    messageP.textContent = text;

    messageDiv.appendChild(avatarImg);
    messageDiv.appendChild(messageP);

    return messageDiv;
}




document.getElementById('user-input').addEventListener('input', function() {
    this.style.height = 'auto'; // Réinitialise la hauteur pour permettre la réduction si le texte est effacé
    this.style.height = (this.scrollHeight) + 'px'; // Ajuste la hauteur en fonction du contenu
});

