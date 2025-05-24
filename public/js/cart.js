// public/js/cart.js

// Recupera carrito de LocalStorage o crea uno nuevo
function getCart() {
  return JSON.parse(localStorage.getItem('cart') || '[]');
}

// Guarda el carrito en LocalStorage
function saveCart(cart) {
  localStorage.setItem('cart', JSON.stringify(cart));
}

// Añade un producto al carrito
function addToCart(product) {
  const cart = getCart();
  cart.push(product);
  saveCart(cart);
  alert(`${product.name} agregado al carrito.`);
}

// Renderiza los productos del carrito en la vista /carrito
function renderCartItems() {
  const container = document.getElementById('cart-items');
  const cart = getCart();
  if (!container) return;
  if (cart.length === 0) {
    container.innerHTML = '<p>No hay productos en el carrito.</p>';
    return;
  }
  let html = '<ul class="space-y-4">';
  cart.forEach((item, idx) => {
    html += `
      <li class="flex items-center space-x-4 p-4 bg-white rounded shadow">
        <img src="${item.img}" alt="${item.name}" class="w-16 h-16 object-cover rounded">
        <div>
          <h3 class="font-semibold">${item.name}</h3>
        </div>
        <button onclick="removeItem(${idx})" class="ml-auto px-2 py-1 bg-red-500 text-white rounded">Eliminar</button>
      </li>`;
  });
  html += '</ul>';
  container.innerHTML = html;
}

// Elimina un ítem por índice y vuelve a renderizar
function removeItem(index) {
  const cart = getCart();
  cart.splice(index, 1);
  saveCart(cart);
  renderCartItems();
}

// Si estamos en la página carrito, renderizamos al cargar
document.addEventListener('DOMContentLoaded', () => {
  renderCartItems();

  // Agregar manejadores a botones “Agregar”
  document.querySelectorAll('[data-add-cart]').forEach(btn => {
    btn.addEventListener('click', () => {
      const product = JSON.parse(btn.dataset.product);
      addToCart(product);
    });
  });
});
