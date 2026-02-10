/**
 * Obsługa modalu produktu
 */

import { escapeHtml } from './utils.js';

let modalElement = null;
let imageZoomListener = null; // Przechowywanie referencji do listenera

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
        <a href="/kontakt" class="modal__button">Zapytaj o produkt</a>
      </div>
    </div>
  `;
  
  document.body.appendChild(modal);
  modalElement = modal;
  
  // Inicjalizacja event listenerów dla zamykania modalu
  initModalCloseListeners();
}

// Inicjalizacja nasłuchiwaczy zamykania modalu
function initModalCloseListeners() {
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

// Inicjalizacja zoom na zdjęciu - wywoływana przy każdym otwarciu modalu
function initImageZoom() {
  const imageContainer = modalElement?.querySelector('.modal__image-container');
  
  if (!imageContainer) return;
  
  // Usuń stary listener jeśli istnieje
  if (imageZoomListener) {
    imageContainer.removeEventListener('click', imageZoomListener);
  }
  
  // Stwórz nowy listener
  imageZoomListener = (e) => {
    e.stopPropagation();
    imageContainer.classList.toggle('modal__image-container--zoomed');
  };
  
  // Dodaj nowy listener
  imageContainer.addEventListener('click', imageZoomListener);
}

// Otwieranie modalu
// Otwieranie modalu
export function openModal(product) {
  if (!modalElement) {
    createModal();
  }

  const modalImage = document.getElementById('modal-image');
  const modalTitle = document.getElementById('modal-title');
  const modalDescription = document.getElementById('modal-description');

  if (!modalImage || !modalTitle || !modalDescription) return;

  // Upewnij się, że zoom jest wyłączony z poprzedniego użycia
  const imageContainer = modalElement.querySelector('.modal__image-container');
  if (imageContainer) {
    imageContainer.classList.remove('modal__image-container--zoomed');
  }

  // Poprawiona ścieżka do obrazka - użyj tylko /img/products/
  modalImage.src = `/${product.image}`;  // Poprawiona ścieżka
  modalImage.alt = product.name;
  modalTitle.textContent = product.name;
  modalDescription.textContent = product.description;

  // Pokaż modal
  modalElement.classList.add('modal--active');
  document.body.style.overflow = 'hidden';

  // Inicjalizacja zoomu
  initImageZoom();
}

// Zamykanie modalu
export function closeModal() {
  if (!modalElement) return;
  
  const imageContainer = modalElement.querySelector('.modal__image-container');
  
  // Usuń klasę zoom jeśli jest aktywna
  if (imageContainer) {
    imageContainer.classList.remove('modal__image-container--zoomed');
  }
  
  // Usuń event listener zoom przy zamykaniu
  if (imageZoomListener && imageContainer) {
    imageContainer.removeEventListener('click', imageZoomListener);
    imageZoomListener = null;
  }
  
  // Zamknij modal
  modalElement.classList.remove('modal--active');
  document.body.style.overflow = '';
}

// Cleanup przy usuwaniu modalu
export function destroyModal() {
  if (modalElement) {
    // Usuń listener ESC
    document.removeEventListener('keydown', handleEscapeKey);
    
    // Usuń listener zoom
    const imageContainer = modalElement.querySelector('.modal__image-container');
    if (imageZoomListener && imageContainer) {
      imageContainer.removeEventListener('click', imageZoomListener);
      imageZoomListener = null;
    }
    
    // Usuń modal z DOM
    modalElement.remove();
    modalElement = null;
  }
}
