document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector(".brands__track");
  
  if (!track) return;
  
  // Pobierz wszystkie oryginalne elementy
  const items = Array.from(track.children);
  const itemCount = items.length;
  
  // Sklonuj całą zawartość tracka wystarczająco dużo razy
  // aby wypełnić ekran i mieć płynną pętlę
  const cloneCount = Math.ceil(window.innerWidth / (track.offsetWidth || 1)) + 2;
  
  for (let i = 0; i < cloneCount; i++) {
    items.forEach(item => {
      track.appendChild(item.cloneNode(true));
    });
  }
  
  // Oblicz całkowitą szerokość jednej grupy (oryginalne elementy)
  // Musimy poczekać na załadowanie obrazków
  const images = track.querySelectorAll('img');
  let loadedImages = 0;
  
  const initAnimation = () => {
    // Oblicz szerokość jednej grupy
    const gap = parseFloat(getComputedStyle(track).gap) || 0;
    let groupWidth = 0;
    
    for (let i = 0; i < itemCount; i++) {
      const item = track.children[i];
      groupWidth += item.offsetWidth;
    }
    groupWidth += gap * itemCount; // Dodaj wszystkie gapy
    
    // Utwórz animację CSS
    const duration = 10; // Sekundy - zmień aby przyspieszyć/zwolnić
    
    const keyframes = `
      @keyframes brandScroll {
        0% {
          transform: translateX(0);
        }
        100% {
          transform: translateX(-${groupWidth}px);
        }
      }
    `;
    
    // Dodaj keyframes do dokumentu
    const style = document.createElement('style');
    style.textContent = keyframes;
    document.head.appendChild(style);
    
    // Zastosuj animację
    track.style.animation = `brandScroll ${duration}s linear infinite`;
  };
  
  // Czekaj na załadowanie wszystkich obrazków
  images.forEach(img => {
    if (img.complete) {
      loadedImages++;
    } else {
      img.addEventListener('load', () => {
        loadedImages++;
        if (loadedImages === images.length) {
          initAnimation();
        }
      });
      
      // Fallback na wypadek błędu ładowania
      img.addEventListener('error', () => {
        loadedImages++;
        if (loadedImages === images.length) {
          initAnimation();
        }
      });
    }
  });
  
  // Jeśli wszystkie obrazki już załadowane
  if (loadedImages === images.length) {
    initAnimation();
  }
  
  // Fallback - uruchom po 500ms nawet jak obrazki się nie załadowały
  setTimeout(() => {
    if (loadedImages < images.length) {
      initAnimation();
    }
  }, 500);
});