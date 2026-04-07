document.addEventListener("DOMContentLoaded", () => {
    fetch("/data/opening-hours.json")
        .then(response => response.json())
        .then(data => {
            const hours = data.summer; // w razie zmiany sezonu, wystarczy tu zmienić na summer/winter

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
        })
        .catch(err => console.error("Błąd ładowania godzin otwarcia:", err));
});