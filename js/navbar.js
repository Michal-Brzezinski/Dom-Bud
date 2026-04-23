document.addEventListener("DOMContentLoaded", () => {

    /* ============================================
       HAMBURGER
    ============================================ */
    const toggle = document.querySelector('.navbar__toggle');
    const menu = document.querySelector('.navbar__menu');
    const social = document.querySelector('.navbar__social');

    if (toggle && menu && social) {
        toggle.addEventListener('click', () => {
            menu.classList.toggle('active');
            social.classList.toggle('active');
        });
    }

    /* ============================================
       STATUS W NAVBARZE
    ============================================ */
    const statusBox   = document.querySelector(".navbar-status");
    const statusText  = document.getElementById("store-status");

    /* ============================================
       PANEL BOCZNY
    ============================================ */
    const panel       = document.getElementById("store-panel");
    const overlay     = document.getElementById("store-panel-overlay");
    const trigger     = document.getElementById("status-trigger");
    const closeBtn    = document.getElementById("panel-close");

    // Otwieranie panelu — tylko desktop
    if (trigger && panel && overlay && window.innerWidth >= 1280) {
        trigger.addEventListener("click", () => {
            panel.classList.add("active");
            overlay.classList.add("active");
        });
    }

    // Zamknięcie panelu
    function closePanel() {
        if (panel)   panel.classList.remove("active");
        if (overlay) overlay.classList.remove("active");
    }

    if (closeBtn)  closeBtn.addEventListener("click", closePanel);
    if (overlay)   overlay.addEventListener("click", closePanel);

    /* ============================================
       JEŚLI NIE MA STATUSU — KOŃCZYMY
    ============================================ */
    if (!statusBox || !statusText) {
        return;
    }

    /* ============================================
       POBIERANIE DANYCH
    ============================================ */
    Promise.all([
        fetch("/data/opening-hours.json").then(r => r.json()),
        fetch("/data/store-data.json").then(r => r.json())
    ])
    .then(([hoursData, storeData]) => {
        const hours = hoursData.summer || hoursData; // fallback, gdyby nie było "summer"

        renderPanel(storeData, hours);
        computeStatus(hours);
    })
    .catch(err => {
        console.error("Błąd ładowania danych:", err);
        statusText.textContent = "Błąd ładowania danych";
    });

    /* ============================================
       STATUS OTWARTE / ZAMKNIĘTE
    ============================================ */
    function computeStatus(hours) {
        if (!hours || !hours.days) {
            statusText.textContent = "Brak danych o godzinach";
            return;
        }

        const now         = new Date();
        const dayNum      = now.getDay();
        const currentTime = now.getHours() * 60 + now.getMinutes();

        const schedule = [
            hours.days.sunday.hours,
            hours.days.monday_friday.hours,
            hours.days.monday_friday.hours,
            hours.days.monday_friday.hours,
            hours.days.monday_friday.hours,
            hours.days.monday_friday.hours,
            hours.days.saturday.hours
        ];

        const todayHours = schedule[dayNum];

        if (!todayHours || typeof todayHours !== "string") {
            statusText.textContent = "Brak danych dzisiaj";
            return;
        }

        if (todayHours.toLowerCase().includes("nieczynne")) {
            setClosed("Zamknięte");
            return;
        }

        const [openStr, closeStr] = todayHours.split(" - ");
        const openMin  = timeToMin(openStr);
        const closeMin = timeToMin(closeStr);

        if (isNaN(openMin) || isNaN(closeMin)) {
            statusText.textContent = "Błędny format godzin";
            return;
        }

        if (currentTime >= openMin && currentTime < closeMin) {
            setOpen(`Otwarte do ${closeStr}`);
        } else {
            setClosed("Zamknięte");
        }
    }

    function timeToMin(str) {
        const [h, m] = str.split(":").map(Number);
        return h * 60 + m;
    }

    function setOpen(msg) {
        statusBox.classList.remove("closed");
        statusBox.classList.add("open");
        statusText.textContent = msg;

        // status w panelu
        const panelStatusText = document.getElementById("panel-status-text");
        const panelDot        = panelStatusText
            ? panelStatusText.parentElement.querySelector(".status-dot")
            : null;

        if (panelStatusText) panelStatusText.textContent = msg;
        if (panelDot)        panelDot.style.background = "var(--status-green)";
    }

    function setClosed(msg) {
        statusBox.classList.remove("open");
        statusBox.classList.add("closed");
        statusText.textContent = msg;

        // status w panelu
        const panelStatusText = document.getElementById("panel-status-text");
        const panelDot        = panelStatusText
            ? panelStatusText.parentElement.querySelector(".status-dot")
            : null;

        if (panelStatusText) panelStatusText.textContent = msg;
        if (panelDot)        panelDot.style.background = "var(--status-red)";
    }

    /* ============================================
       RENDER PANELU BOCZNEGO
    ============================================ */
    function renderPanel(store, hours) {
        if (!store || !hours) return;

        const nameEl   = document.getElementById("panel-store-name");
        const addrEl   = document.getElementById("panel-address");
        const phoneEl  = document.getElementById("panel-phone");
        const mapEl    = document.getElementById("panel-map");
        const offerBtn = document.getElementById("panel-offer-btn");
        const hoursEl  = document.getElementById("panel-hours");

        if (nameEl)   nameEl.textContent  = store.name || "";
        if (addrEl)   addrEl.textContent  = store.address || "";
        if (phoneEl)  phoneEl.textContent = store.phone || "";

        if (mapEl && store.location && store.location.maps_embed) {
            mapEl.src = store.location.maps_embed;
        }

        if (offerBtn && store.links && store.links.offer) {
            offerBtn.href = store.links.offer;
        }

        if (hoursEl && hours.days) {
            hoursEl.innerHTML = `
                <li><span>Pon - Pt</span><span>${hours.days.monday_friday.hours}</span></li>
                <li><span>Soboty</span><span>${hours.days.saturday.hours}</span></li>
                <li><span>Niedziele</span><span>${hours.days.sunday.hours}</span></li>
            `;
        }

        const navbarPhone = document.getElementById("navbar-phone");
        
        if (navbarPhone && store.phone) {
            navbarPhone.textContent = store.phone;
        }
    }

});
