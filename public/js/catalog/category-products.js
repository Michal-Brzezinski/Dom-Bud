import { createModal, openModal } from './modal.js';

// Pobierz wszystkie karty produktów wygenerowane w PHP
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.products__card');

    if (!cards.length) return;

    // Utwórz modal raz
    createModal();

    cards.forEach(card => {
        card.addEventListener('click', () => {
            const product = {
                name: card.querySelector('.products__title').textContent,
                description: card.querySelector('.products__description').textContent,
                image: card.querySelector('.products__image').getAttribute('src').replace(/^\//, '')
            };

            openModal(product);
        });
    });
});
