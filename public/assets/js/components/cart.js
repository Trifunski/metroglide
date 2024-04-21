import APIHandler from "../api/apiHandler";

class Cart {
    
    constructor() {
        this.api = new APIHandler('/api');
    }

    async fetchCart() {
        return await this.api.fetchCart();
    }

    async fetchSneakerDetails(id) {
        return await this.api.fetchSneakerDetails(id);
    }

    async fetchSizes(id) {
        return await this.api.fetchSizes(id);
    }

    async fetchBrands() {
        return await this.api.fetchBrands();
    }

    async fetchSneakers(brandId = '') {
        return await this.api.fetchSneakers(brandId);
    }

    async addToCart(sneakerId, size) {
        return await this.api.fetch('/cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ sneakerId, size })
        });
    }

    async removeFromCart(sneakerId, size) {
        return await this.api.fetch('/cart', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ sneakerId, size })
        });
    }

    async checkout() {
        return await this.api.fetch('cart/checkout', {
            method: 'POST'
        });
    }

}

export default Cart;