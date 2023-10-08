const cardCartElements = document.querySelectorAll('.card-cart');

cardCartElements.forEach((cardCartElement) => {
    // Vérifie si l'élément 'card-cart' a un enfant avec la classe 'have'
    const hasHaveClass = cardCartElement.querySelector('.have');

    // Si l'élément 'card-cart' n'a pas d'enfant avec la classe 'have', met une opacité de 'card_img' à 0.25
    if (!hasHaveClass) {
        const cardImgElement = cardCartElement.querySelector('.card_img');
        cardImgElement.style.opacity = '0.25';
    }
});