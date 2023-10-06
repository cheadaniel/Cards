import { createCommentary } from './functions.js';

const commentForm = document.querySelector('.commentForm');
const currentUrl = window.location.href;

commentForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const commentFormContent = document.getElementById('commentContent');
    createCommentary(currentUrl, commentForm, commentFormContent)
})