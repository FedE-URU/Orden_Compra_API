// frontend-js/js/app.js

document.addEventListener('DOMContentLoaded', () => {
    const productListSection = document.getElementById('product-list-section');
    const shoppingCartSection = document.getElementById('shopping-cart-section');
    const checkoutFormSection = document.getElementById('checkout-form-section');
    const orderConfirmationSection = document.getElementById('order-confirmation-section');

    const showProductsButton = document.getElementById('show-products');
    const showCartButton = document.getElementById('show-cart');
    const cartCountSpan = document.getElementById('cart-count');
    const productListDiv = document.getElementById('product-list');
    const cartItemsDiv = document.getElementById('cart-items');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    const cartTotalSpan = document.getElementById('cart-total');
    const checkoutButton = document.getElementById('checkout-button');
    const checkoutForm = document.getElementById('checkout-form');
    const montoPagoInput = document.getElementById('montoPago');
    const confirmedOrderIdSpan = document.getElementById('confirmed-order-id');
    const continueShoppingButton = document.getElementById('continue-shopping');

    let currentActiveSection = productListSection;

    // --- Funciones de Utilidad de UI ---
    function showSection(section) {
        if (currentActiveSection) {
            currentActiveSection.classList.add('hidden-section');
        }
        section.classList.remove('hidden-section');
        currentActiveSection = section;
    }

    function updateCartUI() {
        const items = cart.getCartItems();
        cartCountSpan.textContent = items.reduce((count, item) => count + item.quantity, 0);
        cartTotalSpan.textContent = cart.getTotal().toFixed(2);
        checkoutButton.disabled = items.length === 0;

        cartItemsDiv.innerHTML = ''; // Limpiar ítems existentes

        if (items.length === 0) {
            emptyCartMessage.classList.remove('hidden');
        } else {
            emptyCartMessage.classList.add('hidden');
            const ul = document.createElement('ul');
            items.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <div class="cart-item-info">
                        <h3>${item.product.nombre}</h3>
                        <p>Precio unitario: $${item.product.precio.toFixed(2)}</p>
                    </div>
                    <div class="cart-item-controls">
                        <button class="update-quantity-btn" data-id="${item.product.productId}" data-action="decrease">-</button>
                        <span>Cantidad: ${item.quantity}</span>
                        <button class="update-quantity-btn" data-id="${item.product.productId}" data-action="increase">+</button>
                        <button class="remove-item" data-id="${item.product.productId}">Eliminar</button>
                    </div>
                    <p>Subtotal: $${(item.product.precio * item.quantity).toFixed(2)}</p>
                `;
                ul.appendChild(li);
            });
            cartItemsDiv.appendChild(ul);

            // Añadir event listeners a los botones de cantidad y eliminar
            ul.querySelectorAll('.update-quantity-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const productId = parseInt(event.target.dataset.id);
                    const action = event.target.dataset.action;
                    const item = items.find(i => i.product.productId === productId);
                    if (item) {
                        const newQuantity = action === 'increase' ? item.quantity + 1 : item.quantity - 1;
                        cart.updateQuantity(productId, newQuantity);
                    }
                });
            });

            ul.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', (event) => {
                    const productId = parseInt(event.target.dataset.id);
                    cart.removeItem(productId);
                });
            });
        }
    }

    async function loadProducts() {
        const products = await api.getProducts();
        productListDiv.innerHTML = '';
        if (products.length > 0) {
            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.classList.add('product-card');
                productCard.innerHTML = `
                    <h3>${product.nombre}</h3>
                    <p>Precio: $${product.precio.toFixed(2)}</p>
                    <button class="add-to-cart-btn" data-id="${product.productId}" data-name="${product.nombre}" data-price="${product.precio}">Agregar al Carrito</button>
                `;
                productListDiv.appendChild(productCard);
            });

            // Añadir event listeners a los botones "Agregar al Carrito"
            productListDiv.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const productId = parseInt(event.target.dataset.id);
                    const productName = event.target.dataset.name;
                    const productPrice = parseFloat(event.target.dataset.price);
                    cart.addToCart({ productId, nombre: productName, precio: productPrice }); // Solo las propiedades necesarias
                });
            });
        } else {
            productListDiv.innerHTML = '<p>No hay productos disponibles en este momento.</p>';
        }
    }

    // --- Event Listeners ---
    showProductsButton.addEventListener('click', () => {
        showSection(productListSection);
        loadProducts(); // Recargar productos por si acaso
    });

    showCartButton.addEventListener('click', () => {
        showSection(shoppingCartSection);
        updateCartUI(); // Asegurarse de que el carrito esté actualizado
    });

    checkoutButton.addEventListener('click', () => {
        showSection(checkoutFormSection);
        montoPagoInput.value = cart.getTotal().toFixed(2); // Pre-rellenar el monto
    });

    checkoutForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Prevenir el envío del formulario por defecto

        const total = cart.getTotal();
        if (total <= 0) {
            alert('El carrito está vacío. Agrega productos antes de realizar el checkout.');
            return;
        }

        const formData = new FormData(checkoutForm);
        const orderData = {
            clienteId: 1, // Por ahora, un ID de cliente fijo
            nombreCliente: formData.get('nombreCliente'),
            direccionCliente: formData.get('direccionCliente'),
            montoPago: parseFloat(formData.get('montoPago')),
            metodoPago: formData.get('metodoPago'),
            items: cart.getCartItems().map(item => ({
                productoId: item.product.productId,
                cantidad: item.quantity
            }))
        };

        try {
            const response = await api.submitOrder(orderData);
            confirmedOrderIdSpan.textContent = response.order_id || 'N/A';
            showSection(orderConfirmationSection);
            cart.clearCart(); // Limpiar carrito después de la orden exitosa
        } catch (error) {
            alert('Error al procesar la orden: ' + error.message);
            console.error('Error al procesar la orden:', error);
        }
    });

    continueShoppingButton.addEventListener('click', () => {
        showSection(productListSection);
        loadProducts(); // Volver a cargar el catálogo
    });

    // Suscribir la UI a los cambios del carrito
    cart.subscribe(updateCartUI);

    // --- Inicialización ---
    loadProducts();
    updateCartUI(); // Inicializar el conteo del carrito al cargar la página
});
