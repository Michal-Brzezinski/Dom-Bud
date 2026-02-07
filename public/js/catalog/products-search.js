document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('catalog-search');
    const cards = [...document.querySelectorAll('.products__card')];

    if (!searchInput || !cards.length) return;

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();

        cards.forEach(card => {
            const title = card.querySelector('.products__title').textContent.toLowerCase();
            const match = title.includes(query);
            card.style.display = match ? '' : 'none';
        });
    });
});
