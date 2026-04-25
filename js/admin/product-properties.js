document.addEventListener("DOMContentLoaded", () => {

    const list = document.getElementById("properties-list");
    const addBtn = document.getElementById("add-property-btn");
    const jsonInput = document.getElementById("properties-json");

    if (!list || !addBtn || !jsonInput) return;

    let props = {};

    try {
        props = JSON.parse(jsonInput.value || "{}");
    } catch {
        props = {};
    }

    const render = () => {
        list.innerHTML = "";

        Object.entries(props).forEach(([key, value]) => {
            const row = document.createElement("div");
            row.classList.add("property-row");

            const keyInput = document.createElement("input");
            keyInput.type = "text";
            keyInput.value = key;
            keyInput.placeholder = "Nazwa";
            keyInput.classList.add("property-key");

            const valueInput = document.createElement("input");
            valueInput.type = "text";
            valueInput.value = value;
            valueInput.placeholder = "Wartość";
            valueInput.classList.add("property-value");

            const delBtn = document.createElement("button");
            delBtn.type = "button";
            delBtn.textContent = "Usuń";
            delBtn.classList.add("btn-danger-small");

            // 🔥 wartość zmienia się na bieżąco
            valueInput.oninput = () => {
                props[key] = valueInput.value;
                jsonInput.value = JSON.stringify(props);
            };

            // 🔥 zmiana klucza dopiero po opuszczeniu pola
            keyInput.onblur = () => {
                const newKey = keyInput.value.trim();

                if (!newKey || newKey === key) return;

                // jeśli nowy klucz już istnieje → nie nadpisujemy
                if (props[newKey]) {
                    keyInput.value = key;
                    return;
                }

                props[newKey] = props[key];
                delete props[key];

                jsonInput.value = JSON.stringify(props);
                render(); // dopiero teraz odświeżamy
            };

            delBtn.onclick = () => {
                delete props[key];
                jsonInput.value = JSON.stringify(props);
                render();
            };

            row.appendChild(keyInput);
            row.appendChild(valueInput);
            row.appendChild(delBtn);

            list.appendChild(row);
        });

        jsonInput.value = JSON.stringify(props);
    };

    addBtn.onclick = () => {
        let newKey = "nowa_właściwość";
        let i = 1;

        while (props[newKey]) {
            newKey = "nowa_właściwość_" + i;
            i++;
        }

        props[newKey] = "";
        render();
    };

    render();
});
