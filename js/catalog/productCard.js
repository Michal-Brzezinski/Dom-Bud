/**
 * Tworzenie kart produktów
 */

import { escapeHtml } from './utils.js';
import { openModal } from './modal.js';

// Tworzenie pojedynczej karty produktu
export function createProductCard(product) {
  const card = document.createElement('div');
  card.className = 'products__card';
  
  card.innerHTML = `
    <div class="products__image-wrapper">
      <img src="${product.image}" alt="${escapeHtml(product.name)}" class="products__image">
    </div>
    <div class="products__content">
      <h3 class="products__title">${escapeHtml(product.name)}</h3>
      <p class="products__description">${escapeHtml(product.description)}</p>
      <span class="products__more">Kliknij, aby zobaczyć więcej →</span>
    </div>
  `;
  
  // Obsługa kliknięcia w kartę
  card.addEventListener('click', () => {
    openModal(product);
  });
  
  return card;
}

// Renderowanie wszystkich kart w gridzie
export function renderProducts(products, container) {
  // Wyczyść kontener
  container.innerHTML = '';
  
  // Sprawdź czy są produkty
  if (!products || products.length === 0) {
    container.innerHTML = '<div class="products__error">Brak produktów do wyświetlenia.</div>';
    return;
  }
  
  // Stwórz karty dla każdego produktu
  const fragment = document.createDocumentFragment();
  
  products.forEach(product => {
    const card = createProductCard(product);
    fragment.appendChild(card);
  });
  
  container.appendChild(fragment);
}