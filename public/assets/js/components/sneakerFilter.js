import APIHandler from "../api/apiHandler.js";

class SneakerFilter {
    constructor() {
        this.filterForm = document.getElementById("filterForm");
        this.filterBrand = document.getElementById("filterBrand");
        this.filterSize = document.getElementById("filterSize");
        this.filterPrice = document.getElementById("filterPrice");
        this.sneakerList = document.getElementById("sneakersContainer");

        this.api = new APIHandler("/api/adrian");
        //this.filterForm.addEventListener("submit", this.handleFilter.bind(this));
        this.loadAllSneakers();
    }

    async loadAllSneakers() {
        try {
            const sneakers = await this.api.fetchSneakers();
            this.displaySneakers(sneakers);
        }
        catch (error) {
            console.error(error);
        }
    }

    async handleFilter(event) {
        event.preventDefault();
        const brands = Array.from(this.filterBrand.selectedOptions).map(opt => opt.value);
        const sizes = Array.from(this.filterSize.selectedOptions).map(opt => opt.value);
        const price = this.filterPrice.value;

        const sneakers = await this.api.fetchFilteredSneakers({ brands, sizes, price });
        this.displaySneakers(sneakers);
    }

    displaySneakers(sneakers) {
        this.sneakerList.innerHTML = "";
        sneakers.forEach(sneaker => {
            const sneakerCard = document.createElement("div");
            sneakerCard.className = "m-2 bg-white rounded-lg overflow-hidden shadow-lg transform transition duration-500 hover:scale-105";
        
            sneakerCard.innerHTML = `
            <a href="/SneakerView?id=${sneaker.Sneaker_ID}" class="block w-full h-full">
                <img src="${sneaker.Sneaker_ImageURL}" class="w-full h-48 object-cover" alt="${sneaker.Sneaker_Model}">
                <div class="p-4 bg-white">
                    <h5 class="text-xl font-bold text-gray-900">${sneaker.Sneaker_Model}</h5>
                </div>
                <div class="px-4 pb-4">
                    <p class="text-gray-700 text-base">${sneaker.Sneaker_Description}
                    <p class="text-gray-900 font-semibold mt-2">$${sneaker.Sneaker_Price}</p>
                </div>
            </a>
            `;
            this.sneakerList.appendChild(sneakerCard);
        });               
    }
}

export default SneakerFilter;