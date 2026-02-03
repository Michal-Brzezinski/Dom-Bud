async function loadPartial(id, file) {
  try {
    const response = await fetch(file);
    if (!response.ok) {
      throw new Error(`Nie udało się załadować pliku: ${file}`);
    }
    const html = await response.text();
    document.getElementById(id).innerHTML = html;

    // Po wczytaniu navbaru podłącz obsługę hamburgera
    if (id === "navbar-placeholder") {
      const toggle = document.querySelector(".navbar__toggle");
      const menu = document.querySelector(".navbar__menu");
      const social = document.querySelector(".navbar__social");

      toggle.addEventListener("click", () => {
        menu.classList.toggle("active");
        social.classList.toggle("active");
      });
    }
  } catch (error) {
    console.error("Błąd ładowania partiala:", error);
    document.getElementById(id).innerHTML =
      `<div class="error">Nie udało się załadować sekcji: ${file}</div>`;
  }
}

document.addEventListener("DOMContentLoaded", () => {
  loadPartial("navbar-placeholder", "partials/navbar.html");
  loadPartial("footer-placeholder", "partials/footer.html");
});
