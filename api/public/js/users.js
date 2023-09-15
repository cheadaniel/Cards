import {sendMessageFromUsers} from './functions.js'

const contacterButtons = document.querySelectorAll('.contact-btn');
const messageForm = document.querySelector('.messageForm');

// Permet d'afficher le form dans le but d'envoyer un msg et l'associe à l'id du pseudo où l'on clique
contacterButtons.forEach(button => {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        const userReceverId = this.getAttribute('data-user-recever-id');
        messageForm.setAttribute('data-user-recever-id', userReceverId)
            messageForm.style.display = 'block';
    })
})

// Ecouteur d'évenement sur le form, qui va appeler la fonction permettant d'envoyer un message et de rediriger vers la pages des contacts
messageForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const messageFormContent = document.getElementById('messageContent');
    const userSenderId = messageForm.getAttribute('data-user-sender-id');
    const userReceverId = messageForm.getAttribute('data-user-recever-id');
    sendMessageFromUsers(messageFormContent, userSenderId, userReceverId)
})


