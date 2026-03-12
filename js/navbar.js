document.addEventListener("DOMContentLoaded", () => {
  // Hamburger menu
  const toggle = document.querySelector('.navbar__toggle');
  const menu = document.querySelector('.navbar__menu');
  const social = document.querySelector('.navbar__social');

  toggle.addEventListener('click', () => {
      menu.classList.toggle('active');
      social.classList.toggle('active');
  });  
  
  const statusTrigger = document.getElementById("status-trigger");
    const statusText = document.getElementById("store-status");
    const hoursList = document.getElementById("hours-list");

    statusTrigger.addEventListener("click", () => {
        statusTrigger.classList.toggle("is-active");
    });

    fetch("/data/opening-hours.json")
        .then(res => res.json())
        .then(data => {
            const hours = data.winter.days;
            
            // Renderowanie listy wewnątrz dropdowna
            const daysMap = [
                { key: 'monday_friday', label: hours.monday_friday.label },
                { key: 'saturday', label: hours.saturday.label },
                { key: 'sunday', label: hours.sunday.label }
            ];
            hoursList.innerHTML = daysMap.map(day => `
                <li><span>${day.label}</span><span>${hours[day.key].hours}</span></li>
            `).join('');

            // LOGIKA STATUSU
            const now = new Date();
            const dayNum = now.getDay(); // 0-niedziela, 1-pon, itd.
            const currentTime = now.getHours() * 60 + now.getMinutes();

            // Pobieramy dane dla dzisiaj, jutra i poniedziałku (na wypadek weekendu)
            const schedule = [
                hours.sunday.hours,         // 0
                hours.monday_friday.hours,  // 1
                hours.monday_friday.hours,  // 2
                hours.monday_friday.hours,  // 3
                hours.monday_friday.hours,  // 4
                hours.monday_friday.hours,  // 5
                hours.saturday.hours        // 6
            ];

            const todayHours = schedule[dayNum];

            if (todayHours.toLowerCase().includes("nieczynne")) {
                // Jeśli dziś niedziela/wolne, sprawdź kiedy poniedziałek
                const [monOpen] = hours.monday_friday.hours.split(" - ");
                setOffline(`Zamknięte • otwarcie w pon. o ${monOpen}`);
            } else {
                const [openStr, closeStr] = todayHours.split(" - ");
                const openMin = timeToMin(openStr);
                const closeMin = timeToMin(closeStr);

                if (currentTime >= openMin && currentTime < closeMin) {
                    // OTWARTE
                    setOnline(`Otwarte do ${closeStr}`);
                } else if (currentTime < openMin) {
                    // JESZCZE ZAMKNIĘTE (rano)
                    setOffline(`Zamknięte • otwarcie o ${openStr}`);
                } else {
                    // JUŻ ZAMKNIĘTE (wieczorem)
                    let nextDay = (dayNum + 1) % 7;
                    let nextOpenStr = schedule[nextDay].split(" - ")[0];
                    
                    if (nextOpenStr.toLowerCase().includes("nieczynne")) {
                         setOffline(`Zamknięte • zapraszamy w pon. o 07:00`);
                    } else {
                         setOffline(`Zamknięte • otwarcie jutro o ${nextOpenStr}`);
                    }
                }
            }
        });

    function timeToMin(timeStr) {
        const [h, m] = timeStr.split(":").map(Number);
        return h * 60 + m;
    }

    function setOnline(msg) {
        statusText.innerHTML = msg.replace("•", "<span class='status-sep'>|</span>");
        statusTrigger.classList.add("navbar__status--open");
    }

    function setOffline(msg) {
        statusText.innerHTML = msg.replace("•", "<span class='status-sep'>|</span>");
        statusTrigger.classList.add("navbar__status--closed");
    }
});