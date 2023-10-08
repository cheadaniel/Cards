import { fetchAndInsertData, sendMessage, editMessage } from './functions.js';


const messageContainer = document.getElementById('messageContainer');
const messageForm = document.querySelector('.messageForm');
const currentUrl = window.location.href; //permettra d'activer les différents controler avec les ajax 

// Donnée de la page des Users, si un contact a été fait grâce à cette page dans le but d'arriver dans la page des contact avec la conversation déjà chargée
// const idRecever = localStorage.getItem("userReceverId");

// if (idRecever) {
//     fetchAndInsertData(currentUrl + '/' + idRecever, messageContainer)
//     messageForm.setAttribute('data-id', idRecever);
//     messageForm.style.display = 'block';
//     localStorage.removeItem("userReceverId");
// }


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
        messageForm.style.display = 'flex';
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

messageContainer.addEventListener('click', function (event) {
    // Ecouteur d'évènement sur les boutons supprimer concernant une conv qui permet de supprimer un msg
    if (event.target.classList.contains('delete-message')) {
        const messageId = event.target.getAttribute('data-id');
        const messageToDelete = document.querySelector(`.message[data-id="${messageId}"]`);

        if (messageToDelete) {
            messageToDelete.style.display = 'none';
        }
    }

    // Ecouteur d'évèment sur les boutons modifier afin qu'ils affichent un formulaire contenant le message a modifier
    if (event.target.classList.contains('edit-message')) {
        const messageId = event.target.getAttribute('data-id');
        const editForm = document.querySelector(`.edit-form[data-id="${messageId}"]`);
        const messageContent = document.querySelector(`.message[data-id="${messageId}"] .content`);

        if (editForm && messageContent) {
            event.target.disabled = true
            messageContent.style.display = 'none';
            editForm.style.display = 'flex';
        }
    }

    // Ecouteur sur l'envoi du formulaire
    if (event.target.classList.contains('save-edit')) {
        const messageId = event.target.getAttribute('data-id');
        const editForm = document.querySelector(`.edit-form[data-id="${messageId}"]`);
        const messageContent = document.querySelector(`.message[data-id="${messageId}"] .content`);
        const editButton = document.querySelector(`.edit-message[data-id="${messageId}"]`);
        event.preventDefault()


        if (editForm && messageContent) {
            // Nouvelle valeur du contenu du message à partir du formulaire
            const updatedContent = editForm.querySelector('textarea[name="edit-content"]').value;

            // Appel de la fonction pour effectuer la requête ajax qui modifiera le message associé 
            editMessage(messageId, updatedContent)
                .then(data => {
                    if (data.success) {
                        messageContent.textContent = updatedContent;
                        editForm.style.display = 'none';
                        messageContent.style.display = 'block';
                        editButton.disabled = false
                    }
                })
                .catch(error => {
                    console.error('Erreur réseau', error);
                });
        }
    }
})