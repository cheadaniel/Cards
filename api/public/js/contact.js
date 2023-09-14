const messageContainer = document.getElementById('messageContainer');
const messageForm = document.querySelector('.messageForm');
const currentUrl = window.location.href;


const idRecever = localStorage.getItem("userReceverId");
console.log("Donnée récupérée de la page précédente :", idRecever);

if (idRecever) {
    fetchAndInsertData(currentUrl + '/' + idRecever, messageContainer)
    messageForm.setAttribute('data-id', idRecever);
    messageForm.style.display = 'block';
}


// Fonction pour effectuer une requête AJAX et insérer le résultat dans le conteneur
function fetchAndInsertData(url, container) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            container.innerHTML = data;
        })
        .catch(error => {
            console.error('Erreur réseau', error);
        });
}

function sendMessage(url, container) {
    const messageFormContent = document.getElementById('messageContent');
    const content = messageFormContent.value;
    //messageContainer.innerHTML = ''

    fetch(url + '/message/send', {
        method: 'POST',
        body: JSON.stringify({ content }),
        headers: {
            'Content-Type': 'application/json', // Définissez le type de contenu JSON
        },
    })
        .then(response => response.json())
        .then(data => {
            // Insérez le résultat dans le conteneur

            // Réinitialisez le formulaire ou effectuez d'autres actions en fonction de la réponse
            if (data.success) {
                // Réinitialisez le formulaire
                messageForm.reset();
                messageContainer.innerHTML = '\n'
                fetchAndInsertData(url, container);
            }
        })
        .catch(error => {
            console.error('Erreur réseau', error);
        });
}

// Écoutez les clics sur les liens avec la classe "sendMessageLink"
document.querySelectorAll('.sendMessageLink').forEach(link => {
    link.addEventListener('click', function (event) {
        event.preventDefault();
        const userId = this.getAttribute('data-id');
        const urlWithUserId = currentUrl + '/' + userId;
        messageContainer.innerHTML = '\n'

        // Appel de la fonction pour effectuer la première requête AJAX
        fetchAndInsertData(urlWithUserId, messageContainer)
        messageForm.setAttribute('data-id', userId);
        messageForm.style.display = 'block';


    })
})

messageForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const userId = this.getAttribute('data-id');
    const urlWithUserId = currentUrl + '/' + userId;
    sendMessage(urlWithUserId, messageContainer)
})


function loadFromUsersPage(idRecever, url) {

}