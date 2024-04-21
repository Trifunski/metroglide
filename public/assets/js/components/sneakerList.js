import APIHandler from '../api/apiHandler.js';

class SneakerList {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.api = new APIHandler('/api/adrian');
    }

    async loadSneakers(brandId = '') {
        try {
            const sneakers = await this.api.fetchSneakers(brandId);
            this.render(sneakers);
        } catch (error) {
            console.error('Error loading sneakers:', error);
        }
    }

    render(sneakers) {
        this.container.innerHTML = sneakers.map(sneaker => `
            <div class="bg-white p-5 rounded-lg">
                <img class="w-full h-60 object-contain" src="${sneaker.Sneaker_ImageURL}" alt="${sneaker.Sneaker_Model}">
                <h1 class="text-black text-lg font-bold mt-3">${sneaker.Sneaker_Model}</h1>
                <a href="/SneakerView?id=${sneaker.Sneaker_ID}">
                    <button class="bg-black text-white px-4 py-2 mt-3 hover:scale-105">Add to Cart</button>
                </a>
                <span class="text-black text-xl ml-5 font-bold">€${sneaker.Sneaker_Price}</span>
            </div>
        `).join('');
    }
}

export default SneakerList;