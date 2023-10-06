// Fonction pour effectuer une requête ajax et insérer le résultat dans le conteneur
export function fetchAndInsertData(url, container) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            container.innerHTML = data;
        })
        .catch(error => {
            console.error('Erreur réseau', error);
        });
}

//Envoyer un message depuis la page de contact 
export function sendMessage(url, container, form, messageForm) {
    const content = messageForm.value;

    fetch(url + '/message/send', {
        method: 'POST',
        body: JSON.stringify({ content }),
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(response => response.json())
        .then(data => {
            // Insérer le résultat dans le conteneur

            // Réinitialiser le formulaire ou effectuer d'autres actions en fonction de la réponse
            if (data.success) {
                // Réinitialiser le formulaire
                form.reset();
                // Réinitialiser le container, pour éviter un affichage en double
                container.innerHTML = '\n'
                fetchAndInsertData(url, container);
            }
        })
        .catch(error => {
            console.error('Erreur réseau', error);
        });
}

export function sendMessageFromUsers(messageForm, idSender, idRecever) {
    const content = messageForm.value;

    fetch(/contact/ + `${idSender}` + '/' + `${idRecever}` + '/message/send', {
        method: 'POST',
        body: JSON.stringify({ content }),
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Rediriger l'utilisateur vers la page de contact, en stockant l'id du destinataire afin d'afficher directement la conversation
                //localStorage.setItem('userReceverId', idRecever);
                window.location.href = `/contact/${idSender}`;
            }
        })
        .catch(error => {
            console.error('Erreur réseau', error);
        });
}

export function editMessage(idMessage, newContent) {
    return fetch(`/message/edit/${idMessage}`, {
        method: 'POST',
        body: JSON.stringify({ content: newContent }),
        headers: {
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json());
}

export function createCommentary(url, form, commentForm) {
    const content = commentForm.value;
    fetch(url + '/commentary/create', {
        method: 'POST',
        body: JSON.stringify({ content }),
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(response => response.json())
        .then(data => {
            // Réinitialiser le formulaire ou effectuer d'autres actions en fonction de la réponse
            if (data.success) {
                // Réinitialiser le formulaire
                window.location.reload();
                form.reset();
            }
        })
        .catch(error => {
            console.error('Erreur réseau', error);
        });
}