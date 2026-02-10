import { createModal, openModal } from './modal.js';

document.addEventListener('DOMContentLoaded', () => {
    // Pobierz wszystkie karty produktów wygenerowane przez PHP
    const cards = document.querySelectorAll('.products__card');

    if (!cards.length) return;

    // Utwórz modal tylko raz
    createModal();

    cards.forEach(card => {
        card.addEventListener('click', () => {
            const product = {
                name: card.querySelector('.products__title').textContent.trim(),
                description: card.querySelector('.products__description').textContent.trim(),
                image: card.querySelector('.products__image').getAttribute('src').replace(/^\//, '')
            };

            openModal(product);
        });
    });
});
