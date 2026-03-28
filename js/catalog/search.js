// console.log('[search.js] start');

// const input = document.querySelector('.catalog-controls__search');

// if (!input) {
//     console.log('[search.js] brak inputa — kończę działanie skryptu');
// } else {

//     const wrapper = document.createElement('div');
//     wrapper.className = 'catalog-controls__suggestions';
//     input.parentNode.appendChild(wrapper);

//     let timer = null;

//     input.addEventListener('input', () => {
//         clearTimeout(timer);
//         const q = input.value.trim();

//         if (q.length < 2) {
//             wrapper.innerHTML = '';
//             wrapper.style.display = 'none';
//             return;
//         }

//         timer = setTimeout(async () => {
//             try {
//                 console.log('[search.js] fetch /api/search?q=' + q);
//                 const res = await fetch(`/api/search?q=${encodeURIComponent(q)}`);

//                 if (!res.ok) {
//                     console.error('[search.js] HTTP error', res.status);
//                     return;
//                 }

//                 const data = await res.json();
//                 console.log('[search.js] data:', data);

//                 renderSuggestions(data);
//             } catch (e) {
//                 console.error('[search.js] exception:', e);
//             }
//         }, 200);
//     });

//     function renderSuggestions(data) {
//         const { categories = [], products = [] } = data;

//         let html = '';

//         categories.forEach(cat => {
//             html += `
//                 <div class="suggestion" data-type="category" data-slug="${cat.slug}">
//                     <span>${cat.name}</span>
//                     <span class="suggestion-type">(kategoria)</span>
//                 </div>
//             `;
//         });

//         products.forEach(prod => {
//             html += `
//                 <div class="suggestion" data-type="product" data-id="${prod.id}" data-slug="${prod.category_slug}">
//                     <span>${prod.name}</span>
//                 </div>
//             `;
//         });

//         wrapper.innerHTML = html;
//         wrapper.style.display = html ? 'block' : 'none';
//     }

//     wrapper.addEventListener('click', e => {
//         const item = e.target.closest('.suggestion');
//         if (!item) return;

//         const type = item.dataset.type;

//         if (type === 'category') {
//             window.location.href = `/katalog/${item.dataset.slug}`;
//         }

//         if (type === 'product') {
//             window.location.href = `/katalog/${item.dataset.slug}?highlight=${item.dataset.id}`;
//         }
//     });
// }
