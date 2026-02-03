/**
 * Obsługa modalu produktu
 */

import { escapeHtml } from './utils.js';

let modalElement = null;

// Tworzenie struktury modalu
export function createModal() {
  // Sprawdź czy modal już istnieje
  if (document.getElementById('product-modal')) {
    modalElement = document.getElementById('product-modal');
    return;
  }
  
  const modal = document.createElement('div');
  modal.className = 'modal';
  modal.id = 'product-modal';
  
  modal.innerHTML = `
    <div class="modal__content">
      <button class="modal__close" aria-label="Zamknij">&times;</button>
      <div class="modal__image-container">
        <img src="" alt="" class="modal__image" id="modal-image">
      </div>
      <div class="modal__body">
        <h3 class="modal__title" id="modal-title"></h3>
        <p class="modal__description" id="modal-description"></p>
        <a href="kontakt.html" class="modal__button">Zapytaj o produkt</a>
      </div>
    </div>
  `;
  
  document.body.appendChild(modal);
  modalElement = modal;
  
  // Inicjalizacja event listenerów
  initModalEventListeners();
}

// Inicjalizacja nasłuchiwaczy zdarzeń
function initModalEventListeners() {
  if (!modalElement) return;
  
  const closeBtn = modalElement.querySelector('.modal__close');
  closeBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    closeModal();
  });
  
  // Zamknij po kliknięciu w tło
  modalElement.addEventListener('click', (e) => {
    if (e.target === modalElement) {
      closeModal();
    }
  });
  
  // Zamknij po naciśnięciu ESC
  document.addEventListener('keydown', handleEscapeKey);
}

// Obsługa klawisza ESC
function handleEscapeKey(e) {
  if (e.key === 'Escape' && modalElement?.classList.contains('modal--active')) {
    closeModal();
  }
}

// Obsługa zoom na zdjęciu w modalu
function initImageZoom() {
  const imageContainer = modalElement?.querySelector('.modal__image-container');
  
  if (!imageContainer) return;
  
  imageContainer.addEventListener('click', (e) => {
    e.stopPropagation();
    imageContainer.classList.toggle('modal__image-container--zoomed');
  });
}

// Otwieranie modalu
export function openModal(product) {
  if (!modalElement) {
    createModal();
  }
  
  const modalImage = document.getElementById('modal-image');
  const modalTitle = document.getElementById('modal-title');
  const modalDescription = document.getElementById('modal-description');
  
  if (!modalImage || !modalTitle || !modalDescription) return;
  
  // Ustaw zawartość modalu
  modalImage.src = product.image;
  modalImage.alt = product.name;
  modalTitle.textContent = product.name;
  modalDescription.textContent = product.description;
  
  // Pokaż modal
  modalElement.classList.add('modal--active');
  document.body.style.overflow = 'hidden';
  
  // Inicjalizuj zoom na zdjęciu
  initImageZoom();
}

// Zamykanie modalu
export function closeModal() {
  if (!modalElement) return;
  
  modalElement.classList.remove('modal--active');
  document.body.style.overflow = '';
}

// Cleanup przy usuwaniu modalu
export function destroyModal() {
  if (modalElement) {
    document.removeEventListener('keydown', handleEscapeKey);
    modalElement.remove();
    modalElement = null;
  }
}