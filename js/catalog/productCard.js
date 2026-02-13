/**
 * Tworzenie kart produktów
 */

import { escapeHtml } from './utils.js';
import { openModal } from './modal.js';

// Pomocnicza funkcja do generowania ścieżek (zgodna z PHP asset())
function getAssetPath(path) {
  // Pobierz bazowy URL z atrybutu data-base-url na <body> lub użyj domyślnego
  const baseUrl = document.body.dataset.baseUrl || '';
  const cleanPath = path.replace(/^\/+/, ''); // Usuń początkowe slashe
  return baseUrl + (baseUrl && !baseUrl.endsWith('/') ? '/' : '') + cleanPath;
}

// Tworzenie pojedynczej karty produktu
export function createProductCard(product) {
  const card = document.createElement('div');
  card.className = 'products__card';

  // POPRAWKA: Użyj getAssetPath() zamiast bezwzględnej ścieżki
  const imagePath = getAssetPath(product.image);

  card.innerHTML = `
    <div class="products__image-wrapper">
      <img src="${imagePath}" alt="${escapeHtml(product.name)}" class="products__image">
    </div>
    <div class="products__content">
      <h3 class="products__title">${escapeHtml(product.name)}</h3>
      <p class="products__description">${escapeHtml(product.description)}</p>
      <span class="products__more">Kliknij, aby zobaczyć więcej →</span>
    </div>
  `;

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