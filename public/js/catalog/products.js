/**
 * Główny kontroler katalogu produktów
 * Koordynuje ładowanie danych i renderowanie
 */

import { fetchData, showLoading, showError } from './utils.js';
import { renderProducts } from './productCard.js';
import { createModal } from './modal.js';

// Konfiguracja
const CONFIG = {
  dataUrl: '/data/products.json',
  gridSelector: '.products__grid'
};

// Główna funkcja inicjalizująca
async function initCatalog() {
  const productsGrid = document.querySelector(CONFIG.gridSelector);
  
  if (!productsGrid) {
    console.warn('Brak kontenera produktów na stronie');
    return;
  }
  
  try {
    // Pokaż stan ładowania
    showLoading(productsGrid, 'Ładowanie produktów...');
    
    // Pobierz dane produktów
    const products = await fetchData(CONFIG.dataUrl);
    
    // Renderuj karty produktów
    renderProducts(products, productsGrid);
    
    // Utwórz modal
    createModal();
    
    console.log(`✓ Załadowano ${products.length} produktów`);
    
  } catch (error) {
    console.error('Błąd podczas ładowania katalogu:', error);
    showError(productsGrid, 'Wystąpił błąd podczas ładowania produktów. Spróbuj odświeżyć stronę.');
  }
}

// Automatyczne uruchomienie po załadowaniu DOM
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initCatalog);
} else {
  initCatalog();
}

// Export dla potencjalnego użycia zewnętrznego
export { initCatalog };