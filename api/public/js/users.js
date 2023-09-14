const contacterButtons = document.querySelectorAll('.contact-btn');
const messageForm = document.getElementById('messageForm');


contacterButtons.forEach(button => {
    button.addEventListener('click', function (event) {
        event.preventDefault();


        messageForm.style.display = 'block';
    })
})

messageForm.addEventListener('submit', function (event) {
    event.preventDefault();
    sendMessage()

})


function sendMessage() {
    const messageFormContent = document.getElementById('messageContent');
    const content = messageFormContent.value;
    const userSenderId = messageForm.getAttribute('data-user-sender-id');
    const userReceverId = messageForm.getAttribute('data-user-recever-id');

    fetch(/contact/ + `${ userSenderId }` + '/' + `${ userReceverId }` + '/message/send', {
        method: 'POST',
        body: JSON.stringify({ content }),
        headers: {
            'Content-Type': 'application/json', // Définissez le type de contenu JSON
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirigez l'utilisateur vers la page de contact
                window.location.href = `/contact/${userSenderId}`;
            } else {
                // Gérez les erreurs ou affichez un message de confirmation
                console.error('Erreur lors de l\'envoi du message');
            }
        })
        .catch(error => {
            console.error('Erreur réseau', error);
        });
}