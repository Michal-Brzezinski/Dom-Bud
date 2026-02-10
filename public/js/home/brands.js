document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector(".brands__track");
  if (!track) return;

  const items = Array.from(track.children);
  const itemCount = items.length;

  const images = track.querySelectorAll("img");
  let loaded = 0;

  const init = () => {
    let totalWidth = track.offsetWidth;

    // Klonuj aż przekroczy 2× szerokość ekranu
    while (totalWidth < window.innerWidth * 2) {
      items.forEach(item => {
        const clone = item.cloneNode(true);
        track.appendChild(clone);
        totalWidth += clone.offsetWidth;
      });
    }

    // Oblicz szerokość jednej grupy (oryginałów)
    let groupWidth = 0;
    for (let i = 0; i < itemCount; i++) {
      groupWidth += track.children[i].offsetWidth;
    }

    const keyframes = `
      @keyframes brandScroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-${groupWidth}px); }
      }
    `;

    const style = document.createElement("style");
    style.textContent = keyframes;
    document.head.appendChild(style);

    track.style.animation = `brandScroll 60s linear infinite`;
  };

  images.forEach(img => {
    if (img.complete) {
      loaded++;
    } else {
      img.addEventListener("load", () => {
        loaded++;
        if (loaded === images.length) init();
      });
      img.addEventListener("error", () => {
        loaded++;
        if (loaded === images.length) init();
      });
    }
  });

  if (loaded === images.length) init();

  setTimeout(() => {
    if (loaded < images.length) init();
  }, 500);
});
