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

    fetchCart() {
        return this.fetch('cart');
    }

}

export default APIHandler;