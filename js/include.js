async function loadPartial(id, file) {
  const response = await fetch(file);
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

}

document.addEventListener("DOMContentLoaded", () => {
  loadPartial("navbar-placeholder", "partials/navbar.html");
  loadPartial("footer-placeholder", "partials/footer.html");
});
