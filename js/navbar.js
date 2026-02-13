document.addEventListener("DOMContentLoaded", () => {
  const toggle = document.querySelector(".navbar__toggle");
  const menu = document.querySelector(".navbar__menu");
  const social = document.querySelector(".navbar__social");

  if (toggle && menu && social) {
    toggle.addEventListener("click", () => {
      menu.classList.toggle("active");
      social.classList.toggle("active");
    });
  }
});
