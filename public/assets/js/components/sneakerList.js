import APIHandler from '../api/apiHandler.js';

class SneakerList {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.api = new APIHandler('/api/adrian');
    }

    async loadSneakers() {
        try {
            const sneakers = await this.api.fetchSneakers();
            this.render(sneakers);
        } catch (error) {
            console.error('Error loading sneakers:', error);
        }
    }

    render(sneakers) {
        this.container.innerHTML = sneakers.map(sneaker => `
            <a href="/SneakerView?id=${sneaker.Sneaker_ID}">
                <div class="bg-white p-5 rounded-lg">
                <img class="w-full h-60 object-contain" src="${sneaker.Sneaker_ImageURL}" alt="${sneaker.Sneaker_Model}">
                    <h1 class="text-black text-lg font-bold mt-3">${sneaker.Sneaker_Model}</h1>
                    <span class="text-black text-xl ml-5 font-bold">€${sneaker.Sneaker_Price}</span>
                </div>
            </a>
        `).join('');
    }
}

export default SneakerList;