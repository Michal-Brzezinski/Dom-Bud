import { createModal, openModal } from './modal.js';

document.addEventListener('DOMContentLoaded', () => {
    // Pobierz wszystkie karty produktów wygenerowane przez PHP
    const cards = document.querySelectorAll('.products__card');

    if (!cards.length) return;

    // Utwórz modal tylko raz
    createModal();

    cards.forEach(card => {
        card.addEventListener('click', () => {
            // Pobierz dane produktu z karty
            const imgElement = card.querySelector('.products__image');
            const titleElement = card.querySelector('.products__title');
            const descElement = card.querySelector('.products__description');
            
            if (!imgElement || !titleElement || !descElement) {
                console.warn('Missing product card elements');
                return;
            }
            
            // POPRAWKA: Weź pełny src z img (już z asset())
            // NIE usuwaj początkowego slash - asset() już to zrobił
            const imageSrc = imgElement.getAttribute('src');
            
            const product = {
                name: titleElement.textContent.trim(),
                description: descElement.textContent.trim(),
                image: imageSrc  // Użyj pełnej ścieżki bez modyfikacji
            };

            openModal(product);
        });
    });
});