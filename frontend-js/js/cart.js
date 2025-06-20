// frontend-js/js/cart.js

const cart = {
    items: [],
    listeners: [], // Para notificar cambios a la UI

    init: () => {
        const storedCart = localStorage.getItem('shoppingCart');
        if (storedCart) {
            cart.items = JSON.parse(storedCart);
        }
        cart.notifyListeners();
    },

    addToCart: (product) => {
        const existingItem = cart.items.find(item => item.product.productId === product.productId);
        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.items.push({ product, quantity: 1 });
        }
        cart.saveCart();
        cart.notifyListeners();
    },

    updateQuantity: (productId, newQuantity) => {
        const item = cart.items.find(item => item.product.productId === productId);
        if (item) {
            item.quantity = Math.max(1, newQuantity); // Cantidad mínima 1
            cart.saveCart();
            cart.notifyListeners();
        }
    },

    removeItem: (productId) => {
        cart.items = cart.items.filter(item => item.product.productId !== productId);
        cart.saveCart();
        cart.notifyListeners();
    },

    clearCart: () => {
        cart.items = [];
        cart.saveCart();
        cart.notifyListeners();
    },

    getTotal: () => {
        return cart.items.reduce((total, item) => total + (item.product.precio * item.quantity), 0);
    },

    getCartItems: () => {
        return [...cart.items]; // Devuelve una copia para evitar mutaciones directas
    },

    saveCart: () => {
        localStorage.setItem('shoppingCart', JSON.stringify(cart.items));
    },

    // Métodos para el patrón Observer simple para notificar a la UI
    subscribe: (listener) => {
        cart.listeners.push(listener);
    },

    unsubscribe: (listener) => {
        cart.listeners = cart.listeners.filter(l => l !== listener);
    },

    notifyListeners: () => {
        cart.listeners.forEach(listener => listener());
    }
};

// Inicializar el carrito cuando el script se carga
cart.init();
