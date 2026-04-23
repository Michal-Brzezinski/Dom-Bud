document.addEventListener("DOMContentLoaded", () => {

    Promise.all([
        fetch("/data/store-data.json").then(r => r.json()),
        fetch("/data/opening-hours.json").then(r => r.json())
    ])
    .then(([store, hoursData]) => {
        const hours = hoursData.summer; // TODO: automatyczne przełączanie sezonu

        renderContactData(store);
        renderOpeningHours(hours);
    })
    .catch(err => console.error("Błąd ładowania danych kontaktowych:", err));

});

/* ============================
   RENDER DANYCH KONTAKTOWYCH
============================ */
function renderContactData(store) {
    document.querySelector(".contact__value.phone").textContent = store.phone;
    document.querySelector(".contact__value.email").textContent = store.email;
    document.querySelector(".contact__value.address").textContent = store.address;

    // Mapa
    document.getElementById("contact-map").src = store.location.maps_embed;
}

/* ============================
   RENDER GODZIN OTWARCIA
============================ */
function renderOpeningHours(hours) {
    document.getElementById("hours-title").textContent = hours.label;
    document.getElementById("hours-note").textContent = hours.note;

    const container = document.getElementById("opening-hours");
    container.innerHTML = `
        <p><span class="contact__label">${hours.days.monday_friday.label}:</span>
        <span class="contact__hours__label">${hours.days.monday_friday.hours}</span></p>

        <p><span class="contact__label">${hours.days.saturday.label}:</span>
        <span class="contact__hours__label">${hours.days.saturday.hours}</span></p>

        <p><span class="contact__label">${hours.days.sunday.label}:</span>
        <span class="contact__hours__label">${hours.days.sunday.hours}</span></p>
    `;
}
