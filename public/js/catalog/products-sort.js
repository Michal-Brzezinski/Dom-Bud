document.addEventListener('DOMContentLoaded', () => {
    const sortSelect = document.getElementById('catalog-sort');
    const grid = document.querySelector('.products__grid');
    const cards = [...document.querySelectorAll('.products__card')];

    if (!sortSelect || !grid || !cards.length) return;

    sortSelect.addEventListener('change', () => {
        const mode = sortSelect.value;

        const sorted = [...cards].sort((a, b) => {
            const nameA = a.querySelector('.products__title').textContent.trim();
            const nameB = b.querySelector('.products__title').textContent.trim();

            return mode === 'az'
                ? nameA.localeCompare(nameB, 'pl')
                : nameB.localeCompare(nameA, 'pl');
        });

        grid.innerHTML = '';
        sorted.forEach(card => grid.appendChild(card));
    });
});
