// Sélectionnez tous les éléments avec la classe 'card-cart'
const cardCartElements = document.querySelectorAll('.card-cart');

// Parcourez les éléments 'card-cart'
cardCartElements.forEach((cardCartElement) => {
    // Vérifiez si l'élément 'card-cart' a un enfant avec la classe 'have'
    const hasHaveClass = cardCartElement.querySelector('.have');

    // Si l'élément 'card-cart' n'a pas d'enfant avec la classe 'have', réglez l'opacité de 'card_img' à 0.5
    if (!hasHaveClass) {
        const cardImgElement = cardCartElement.querySelector('.card_img');
        cardImgElement.style.opacity = '0.5';
    }
});