/**
 * Funkcje pomocnicze
 */

// Pomocnicza funkcja do generowania ścieżek (zgodna z PHP asset())
export function getAssetPath(path) {
  // Pobierz bazowy URL z atrybutu data-base-url na <body> lub użyj domyślnego
  const baseUrl = document.body.dataset.baseUrl || '';
  const cleanPath = path.replace(/^\/+/, ''); // Usuń początkowe slashe
  return baseUrl + (baseUrl && !baseUrl.endsWith('/') ? '/' : '') + cleanPath;
}

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
  // POPRAWKA: Użyj getAssetPath dla względnych ścieżek
  const fullUrl = url.startsWith('http') ? url : getAssetPath(url);
  
  const response = await fetch(fullUrl);
  if (!response.ok) {
    throw new Error(`HTTP error! status: ${response.status}`);
  }
  return await response.json();
}