// frontend-js/js/api.js

const API_BASE_URL = 'http://localhost/ordenes-compra-php-js/backend-php/api'; // Cambia si tu ruta de servidor web es diferente

const api = {
    getProducts: async () => {
        try {
            const response = await fetch(`${API_BASE_URL}/productos.php`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            return data.records; // El backend devuelve un objeto con la clave 'records'
        } catch (error) {
            console.error("Error fetching products:", error);
            return [];
        }
    },

    submitOrder: async (orderData) => {
        try {
            const response = await fetch(`${API_BASE_URL}/ordenes.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(orderData),
            });
            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || `HTTP error! status: ${response.status}`);
            }
            return data;
        } catch (error) {
            console.error("Error submitting order:", error);
            throw error;
        }
    }
};
