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

// Fonction pour envoyer la requête à l'API GPT-4 et obtenir une réponse
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
    // Définir un contexte initial pour les conversations sur les comics DC et Marvel
    return [
        { role: "system", content: "Vous discutez avec un expert des comics DC et Marvel. L'assistant se limitera à répondre aux questions sur ces univers." }
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

// Fonction pour mettre à jour l'interface utilisateur avec les messages
function updateChatUI(userInput, jarvisResponse) {
    var chatContainer = document.getElementById('chat-container');

    var userMessage = document.createElement('p');
    userMessage.textContent = "Vous: " + userInput;
    chatContainer.appendChild(userMessage);

    var jarvisMessage = document.createElement('p');
    jarvisMessage.textContent = "Jarvis: " + jarvisResponse;
    chatContainer.appendChild(jarvisMessage);

    // Réinitialiser le champ de saisie
    document.getElementById('user-input').value = '';
}
