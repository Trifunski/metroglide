class APIHandler {
    constructor(baseUrl) {
        this.baseUrl = baseUrl;
    }

    async fetch(url, options = {}) {
        const response = await fetch(`${this.baseUrl}/${url}`, options);
        return response.json();
    }

    async fetchPost(url, data) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        return await this.fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': token
            },
            body: JSON.stringify(data)
        });
    }

    fetchSneakers() {
        const endpoint = 'sneakers';
        return this.fetch(endpoint);
    }

    fetchBrands() {
        return this.fetch('brands');
    }

    fetchSneakerDetails(id) {
        return this.fetch(`sneakers/${id}`);
    }

    fetchSizes(id) {
        return this.fetch(`sneakers/size/${id}`);
    }

    fetchAllSizes() {
        return this.fetch('sizes');
    }

    fetchFilteredSneakers(filters) {
        return this.fetchPost('sneakers/filter', filters);
    }

    fetchCart() {
        return this.fetch('cart');
    }

    checkout() {
        return this.fetch('cart/checkout');
    }

    completedOrder() {
        return this.fetch('cart/completed');
    }

    addToCart(sneakerId, sizeId, price) {
        return this.fetchPost('cart/add', {
            sneakerId: sneakerId,
            sizeId: sizeId,
            quantity: 1,
            price: price
        });
    }

    removeFromCart(sneakerId, sizeId, quantity) {
        return this.fetchPost('cart/remove', {
            sneakerId: sneakerId,
            sizeId: sizeId,
            quantity: quantity
        });
    }

    login(email, password) {
        return this.fetchPost('login/auth', { 
            email: email, 
            password: password 
        });
    }

}

export default APIHandler;