document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".contact__form form");

  form.addEventListener("submit", (e) => {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const message = document.getElementById("message").value.trim();

    let errors = [];

    if (name.length < 3) {
      errors.push("Imię i nazwisko musi mieć co najmniej 3 znaki.");
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      errors.push("Podaj poprawny adres e-mail.");
    }

    if (message.length < 10) {
      errors.push("Wiadomość musi mieć co najmniej 10 znaków.");
    }

    if (errors.length > 0) {
      e.preventDefault();

      // usuń stare komunikaty
      const oldMsg = form.querySelector(".form__message");
      if (oldMsg) oldMsg.remove();

      // dodaj nowy komunikat
      const msgBox = document.createElement("div");
      msgBox.className = "form__message error";
      msgBox.textContent = errors.join(" ");
      form.prepend(msgBox);
    }
  });
});
