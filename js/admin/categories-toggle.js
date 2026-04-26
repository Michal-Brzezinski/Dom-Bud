document.addEventListener("DOMContentLoaded", () => {

    const rows = Array.from(document.querySelectorAll(".cat-row"));
    const toggles = document.querySelectorAll(".js-cat-toggle");

    // localStorage klucz
    const STORAGE_KEY = "admin_categories_open";

    // Odczyt stanu
    let openSet = new Set(JSON.parse(localStorage.getItem(STORAGE_KEY) || "[]"));

    const getDepth = (row) => parseInt(row.dataset.depth, 10);

    const getChildren = (parentRow) => {
        const parentDepth = getDepth(parentRow);
        const children = [];

        let found = false;

        for (let row of rows) {
            if (row === parentRow) {
                found = true;
                continue;
            }
            if (!found) continue;

            const depth = getDepth(row);
            if (depth <= parentDepth) break;

            children.push(row);
        }
        return children;
    };

    const collapseRow = (row) => {
        const inner = row.querySelector(".cat-row-inner");
        inner.classList.add("cat-row-inner--collapsed");
        setTimeout(() => row.classList.add("cat-row--hidden"), 300);
    };

    const expandRow = (row) => {
        row.classList.remove("cat-row--hidden");
        const inner = row.querySelector(".cat-row-inner");
        requestAnimationFrame(() => {
            inner.classList.remove("cat-row-inner--collapsed");
        });
    };

    const toggleRow = (parentRow, toggleEl) => {
        const id = parentRow.dataset.id;
        const isOpen = toggleEl.classList.toggle("cat-toggle--open");

        if (isOpen) {
            openSet.add(id);
        } else {
            openSet.delete(id);
        }

        localStorage.setItem(STORAGE_KEY, JSON.stringify([...openSet]));

        const children = getChildren(parentRow);

        children.forEach(child => {
            if (isOpen) expandRow(child);
            else collapseRow(child);
        });
    };

    // Inicjalizacja — wszystko zwinięte
    rows.forEach(row => {
        if (getDepth(row) > 0) {
            row.classList.add("cat-row--hidden");
            row.querySelector(".cat-row-inner").classList.add("cat-row-inner--collapsed");
        }
    });

    // Przywracanie stanu z localStorage
    rows.forEach(row => {
        const id = row.dataset.id;
        if (openSet.has(id)) {
            const toggleEl = document.querySelector(`.js-cat-toggle[data-id="${id}"]`);
            if (toggleEl) {
                toggleEl.classList.add("cat-toggle--open");
                const children = getChildren(row);
                children.forEach(expandRow);
            }
        }
    });

    // Obsługa kliknięć
    toggles.forEach(toggleEl => {
        toggleEl.addEventListener("click", () => {
            const parentRow = rows.find(r => r.dataset.id === toggleEl.dataset.id);
            toggleRow(parentRow, toggleEl);
        });
    });
});
