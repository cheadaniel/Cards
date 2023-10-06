import { createCommentary } from './functions.js';

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
})