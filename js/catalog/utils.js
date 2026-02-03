/**
 * Funkcje pomocnicze
 */

// Escapowanie HTML (zapobiega XSS)
export function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

// Pokazywanie stanu ładowania
export function showLoading(container, message = 'Ładowanie...') {
  container.innerHTML = `<div class="products__loading">${message}</div>`;
}

// Pokazywanie błędu
export function showError(container, message = 'Wystąpił błąd') {
  container.innerHTML = `<div class="products__error">${message}</div>`;
}

// Pobieranie danych z API/JSON
export async function fetchData(url) {
  const response = await fetch(url);
  if (!response.ok) {
    throw new Error(`HTTP error! status: ${response.status}`);
  }
  return await response.json();
}