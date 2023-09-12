// Fonction pour effectuer une requête AJAX et insérer le résultat dans le conteneur
function fetchAndInsertData(url, container) {
    if (container.innerHTML == '') {
        fetch(url)
            .then(response => response.text())
            .then(data => {
                container.innerHTML = data;
            })
            .catch(error => {
                console.error('Erreur réseau', error);
            });
    } else {
        const newDiv = document.createElement('div');
        console.log(url)
        fetch(url)
            .then(response => response.text())
            .then(data => {
                newDiv.innerHTML = data;
                container.appendChild(newDiv);
            })
            .catch(error => {
                console.error('Erreur réseau', error);
            });
    }

}



document.addEventListener('DOMContentLoaded', function () {
    const messageContainer = document.getElementById('messageContainer');

    // Écoutez les clics sur les liens avec la classe "sendMessageLink"
    document.querySelectorAll('.sendMessageLink').forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const userId = this.getAttribute('data-id');
            const currentUrl = window.location.href;
            const urlWithUserId = currentUrl + '/' + userId;

            // Appel de la fonction pour effectuer la première requête AJAX
            fetchAndInsertData(urlWithUserId, messageContainer)

            // Appel de la fonction pour effectuer la deuxième requête AJAX
            setTimeout(fetchAndInsertData(urlWithUserId + '/message', messageContainer),2000)
            

            //3eme requete 
            setTimeout(function () {
                const messageForm = document.forms['message_form'];
                //const messageContainer = document.getElementById('messageContainer');

                messageForm.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const messageFormContent = document.getElementById('message_form_content');
                    const content = messageFormContent.value;

                    fetch(urlWithUserId + '/message/send', {
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
                                console.log(data,messageForm,messageContainer)
                                messageForm.innerHTML = '';
                                messageContainer.innerHTML = ''
                                fetchAndInsertData(urlWithUserId, messageContainer);
                                setTimeout(fetchAndInsertData(urlWithUserId + '/message', messageContainer),10000)
                                console.log(messageForm,messageContainer)

                            }
                        })
                        .catch(error => {
                            console.error('Erreur réseau', error);
                        });
                })
            }, 2000)

        })
    })
})
