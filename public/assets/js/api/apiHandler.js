class APIHandler {
    constructor(baseUrl) {
        this.baseUrl = baseUrl;
    }

    async fetch(url, options = {}) {
        const response = await fetch(`${this.baseUrl}/${url}`, options);
        if (!response.ok) {
            throw new Error('Network response was not ok.');
        }
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

    fetchSneakers(brandId = '') {
        const endpoint = brandId ? `sneakers/brand/${brandId}` : 'sneakers';
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

    addToCart(sneakerId, sizeId) {
        return this.fetchPost('cart/add', {
            sneakerId: sneakerId,
            sizeId: sizeId,
            quantity: 1
        });
    }

    removeFromCart(sneakerId, sizeId) {
        return this.fetchPost('cart/remove', {
            sneakerId: sneakerId,
            sizeId: sizeId
        });
    }

    fetchCart() {
        return this.fetch('cart');
    }

}

export default APIHandler;