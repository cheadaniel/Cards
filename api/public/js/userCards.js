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


const tradableLinks = document.querySelectorAll('.tradable-link');
tradableLinks.forEach(link => {
    link.addEventListener('click', (event) => {

        const cardId = link.getAttribute('data-card-id');

        const tradableParagraph = document.querySelector(`#tradable-${cardId}`);
        const notTradableParagraph = document.querySelector(`#not-tradable-${cardId}`);

        if (tradableParagraph && tradableParagraph.textContent == "Echangeable") {
            tradableParagraph.textContent = "Non Echangeable";
        } else if (tradableParagraph && tradableParagraph.textContent == "Non Echangeable") {
            tradableParagraph.textContent = "Echangeable";
        }

        if (notTradableParagraph && notTradableParagraph.textContent == "Non Echangeable") {
            notTradableParagraph.textContent = "Echangeable";
        } else if (notTradableParagraph && notTradableParagraph.textContent == "Echangeable") {
            notTradableParagraph.textContent = "Non Echangeable";
        }
    });
});

const favoriteLinks = document.querySelectorAll('.favorite-link');
favoriteLinks.forEach(link => {
    link.addEventListener('click', (event) => {

        const cardId = link.getAttribute('data-card-id');

        const favoriteParagraph = document.querySelector(`#favourite-${cardId}`);
        const notFavoriteParagraph = document.querySelector(`#not-favourite-${cardId}`);

        if (favoriteParagraph && favoriteParagraph.textContent == "Favorite") {
            favoriteParagraph.textContent = "Non Favorite";
        } else if (favoriteParagraph && favoriteParagraph.textContent == "Non Favorite") {
            favoriteParagraph.textContent = "Favorite";
        }

        if (notFavoriteParagraph && notFavoriteParagraph.textContent == "Non Favorite") {
            notFavoriteParagraph.textContent = "Favorite";
        } else if (notFavoriteParagraph && notFavoriteParagraph.textContent == "Favorite") {
            notFavoriteParagraph.textContent = "Non Favorite";
        }
    });
});

const incrementLinks = document.querySelectorAll('.increment-button');
const decrementLinks = document.querySelectorAll('.decrement-button');

incrementLinks.forEach(link => {
    link.addEventListener('click', (event) => {
        const cardId = link.getAttribute('data-card-id');
        // Récupérer l'élément <p> de quantité correspondant
        const quantityParagraph = document.querySelector(`#quantity-${cardId}`);

        // Récupérer la valeur actuelle de la quantité
        let currentQuantity = parseInt(quantityParagraph.getAttribute('data-quantity'));

        // Incrémenter la quantité
        currentQuantity += 1;

        // Mettre à jour l'attribut data-quantity
        quantityParagraph.setAttribute('data-quantity', currentQuantity);

        // Mettre à jour le texte du paragraphe de quantité
        quantityParagraph.textContent = `Nombre possédé(s) : ${currentQuantity}`;
    });
});

decrementLinks.forEach(link => {
    link.addEventListener('click', (event) => {
        //event.preventDefault();

        const cardId = link.getAttribute('data-card-id');
        // Récupérer l'élément <p> de quantité correspondant
        const quantityParagraph = document.querySelector(`#quantity-${cardId}`);

        // Récupérer la valeur actuelle de la quantité
        let currentQuantity = parseInt(quantityParagraph.getAttribute('data-quantity'));

        // Vérifier que la quantité est supérieure à zéro avant de décrémenter
        if (currentQuantity > 0) {
            currentQuantity -= 1;

            // Mettre à jour l'attribut data-quantity
            quantityParagraph.setAttribute('data-quantity', currentQuantity);

            // Mettre à jour le texte du paragraphe de quantité
            quantityParagraph.textContent = `Nombre possédé(s) : ${currentQuantity}`;
        }
    });
});
