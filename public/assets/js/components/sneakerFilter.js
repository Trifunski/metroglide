import APIHandler from "../api/apiHandler.js";

class SneakerFilter {
    constructor() {
        this.filterForm = document.getElementById("filterForm");
        this.filterBrand = document.getElementById("containerBrands");
        this.filterSize = document.getElementById("containerSizes");
        this.sneakerList = document.getElementById("sneakersContainer");

        this.api = new APIHandler("/api/adrian");
        //this.filterForm.addEventListener("submit", this.handleFilter.bind(this));
        this.loadAllSneakers();
    }

    async loadAllSneakers() {
        try {
            const sneakers = await this.api.fetchSneakers();
            const brands = await this.api.fetchBrands();
            const sizes = await this.api.fetchAllSizes();
            this.displaySneakers(sneakers);
            this.displayBrands(brands);
            this.displaySizes(sizes);
        }
        catch (error) {
            console.error(error);
        }
    }

    async handleFilter(event) {
        const brands = Array.from(this.filterBrand.querySelectorAll("input:checked")).map(input => input.value);
        const sizes = Array.from(this.filterSize.querySelectorAll("input:checked")).map(input => input.value);

        const filteredBrands = brands.length > 0 ? brands : [];
        const filteredSizes = sizes.length > 0 ? sizes : [];

        const sneakers = await this.api.fetchFilteredSneakers({ brands: filteredBrands, sizes: filteredSizes });
        this.displaySneakers(sneakers);
    }

    displaySneakers(sneakers) {
        this.sneakerList.innerHTML = "";
        sneakers.forEach(sneaker => {
            const sneakerCard = document.createElement("div");
            sneakerCard.className = "m-2 bg-white rounded-lg overflow-hidden shadow-lg transform transition duration-500 hover:scale-105";
        
            sneakerCard.innerHTML = `
            <a href="/SneakerView?id=${sneaker.Sneaker_ID}" class="block w-full h-full">
                <img src="${sneaker.Sneaker_ImageURL}" class="w-full h-48 object-cover p-2" alt="${sneaker.Sneaker_Model}">
                <div class="p-4">
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

    displayBrands(brands) {
        const brandContainer = document.getElementById("containerBrands");
        brandContainer.innerHTML = '';  // Limpiar el contenido existente antes de añadir nuevos elementos
        brands.forEach(brand => {
            const label = document.createElement("label");
            label.className = "block text-gray-300 mb-2";
            label.innerHTML = `
                <input type="checkbox" id="brand-${brand.Brand_ID}" class="mr-2" value="${brand.Brand_ID}">
                ${brand.Brand_Name}
            `;
            brandContainer.appendChild(label);
        });
    }
    
    displaySizes(sizes) {
        const sizeContainer = document.getElementById("containerSizes");
        sizeContainer.innerHTML = '';  // Limpiar el contenido existente antes de añadir nuevos elementos
        sizes.forEach(size => {
            const div = document.createElement("div");
            div.className = "w-1/2 sm:w-1/4 lg:w-1/6 mb-2";
            const label = document.createElement("label");
            label.className = "block text-gray-300";
            label.innerHTML = `
                <input type="checkbox" id="size-${size.Size_ID}" class="mr-2" value="${size.Size_ID}">
                ${size.Size_Value}
            `;
            div.appendChild(label);
            sizeContainer.appendChild(div);
        });
    }
    
}

export default SneakerFilter;