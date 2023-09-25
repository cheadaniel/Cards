import {fetchAndInsertData, sendMessage} from './functions.js';


const messageContainer = document.getElementById('messageContainer');
const messageForm = document.querySelector('.messageForm');
const currentUrl = window.location.href; //permettra d'activer les différents controler avec les ajax 

// Donnée de la page des Users, si un contact a été fait grâce à cette page dans le but d'arriver dans la page des contact avec la conversation déjà chargée
const idRecever = localStorage.getItem("userReceverId");

if (idRecever) {
    fetchAndInsertData(currentUrl + '/' + idRecever, messageContainer)
    messageForm.setAttribute('data-id', idRecever);
    messageForm.style.display = 'block';
    localStorage.removeItem("userReceverId");
}


// Écouter les clics sur les liens avec la classe "sendMessageLink" pour afficher la bonne conversation
document.querySelectorAll('.sendMessageLink').forEach(link => {
    link.addEventListener('click', function (event) {
        event.preventDefault();
        const userId = this.getAttribute('data-id');
        const urlWithUserId = currentUrl + '/' + userId;
        messageContainer.innerHTML = '\n'

        // Appel de la fonction pour effectuer la première requête ajax qui affichera la conversation associé 
        fetchAndInsertData(urlWithUserId, messageContainer)
        messageForm.setAttribute('data-id', userId);
        messageForm.style.display = 'block';
    })
})

// Ecouteur d'évenement sur le form, qui va appeler la fonction permettant d'envoyer un message et rechargez la conversation avec le nouveau message
messageForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const messageFormContent = document.getElementById('messageContent');
    const userId = this.getAttribute('data-id');
    const urlWithUserId = currentUrl + '/' + userId;
    sendMessage(urlWithUserId, messageContainer, messageForm, messageFormContent)
})
