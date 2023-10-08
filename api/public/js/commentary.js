import { createCommentary, editCommentary } from './functions.js';

const commentContainer = document.querySelector(".carte-commentaire");
const commentForm = document.querySelector('.commentForm');
const currentUrl = window.location.href;


commentForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const commentFormContent = document.getElementById('commentContent');
    createCommentary(currentUrl, commentForm, commentFormContent)
})

commentContainer.addEventListener('click', function (event) {
    if (event.target.classList.contains('delete-commentary')) {
        const commentaryId = event.target.getAttribute('data-id');
        const commentaryToDelete = document.querySelector(`.commentaire[data-id="${commentaryId}"]`);
        if (commentaryToDelete) {
            commentaryToDelete.style.display = 'none';
        }
    }
    // Ecouteur d'évèment sur les boutons modifier afin qu'ils affichent un formulaire contenant le message a modifier
    if (event.target.classList.contains('edit-commentary')) {
        const commentaryId = event.target.getAttribute('data-id');
        const editForm = document.querySelector(`.edit-form[data-id="${commentaryId}"]`);
        const commentaryContent = document.querySelector(`.commentaire[data-id="${commentaryId}"] .content`);

        if (editForm && commentaryContent) {
            event.target.disabled = true
            commentaryContent.style.display = 'none';
            editForm.style.display = 'block';
        }
    }

    // Ecouteur sur l'envoi du formulaire
    if (event.target.classList.contains('save-edit')) {
        const commentaryId = event.target.getAttribute('data-id');
        const editForm = document.querySelector(`.edit-form[data-id="${commentaryId}"]`);
        const commentaryContent = document.querySelector(`.commentaire[data-id="${commentaryId}"] .content`);
        const editButton = document.querySelector(`.edit-commentary[data-id="${commentaryId}"]`);
        event.preventDefault()


        if (editForm && commentaryContent) {
            // Nouvelle valeur du contenu du commentary à partir du formulaire
            const updatedContent = editForm.querySelector('textarea[name="edit-content"]').value;

            // Appel de la fonction pour effectuer la requête ajax qui modifiera le message associé 
            editCommentary(commentaryId, updatedContent)
                .then(data => {
                    if (data.success) {
                        commentaryContent.textContent = updatedContent;
                        editForm.style.display = 'none';
                        commentaryContent.style.display = 'block';
                        editButton.disabled = false
                    }
                })
                .catch(error => {
                    console.error('Erreur réseau', error);
                });
        }
    }
})