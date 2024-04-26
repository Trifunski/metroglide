import APIHandler from '../api/apiHandler.js';

class SneakerList {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.api = new APIHandler('/api/adrian');
    }

    async loadSneakers() {
        this.showSkeleton(); // Muestra el esqueleto antes de cargar los datos
        try {
            const sneakers = await this.api.fetchSneakers();
            this.render(sneakers);
        } catch (error) {
            console.error('Error loading sneakers:', error);
        }
    }

    showSkeleton() {
        const skeletons = new Array(9).fill("").map(() => `
            <div class="bg-white p-5 rounded-lg shadow-md col-span-1">
                <div class="animate-pulse flex flex-col items-center">
                    <div class="w-full bg-gray-300 h-60"></div>
                    <div class="h-4 bg-gray-300 mt-3 w-4/5"></div>
                    <div class="h-4 bg-gray-300 mt-2 w-3/5"></div>
                </div>
            </div>
        `).join('');
        this.container.innerHTML = skeletons;
    }    

    render(sneakers) {
        this.container.innerHTML = sneakers.slice(0, 9).map(sneaker => `
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