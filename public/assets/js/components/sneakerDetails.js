import APIHandler from '../api/apiHandler.js';
import Cart from './cart.js';

class SneakerDetails {
    constructor() {
        this.container = document.getElementById('sneakerContainer');  // Asegúrate de tener este ID en tu HTML
        this.api = new APIHandler('/api/adrian');
        this.showSkeleton();
    }

    async loadSneaker(id) {
        try {
            const sneaker = await this.api.fetchSneakerDetails(id);
            const sizes = await this.api.fetchSizes(id);
            this.render(sneaker, sizes);
        } catch (error) {
            console.error('Error loading sneaker details:', error.message);
            alert('Failed to load sneaker details.');
        }
    }

    showSkeleton() {
        const skeletonHTML = `
            <div class="lg:w-4/5 mx-auto flex justify-between">
                <div class="lg:w-1/2 w-full lg:h-auto h-64 bg-gray-300 animate-pulse rounded mr-5"></div>
                <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                    <h2 class="text-3xl font-bold title-font tracking-widest bg-gray-300 animate-pulse h-10 w-3/4"></h2>
                    <h1 class="text-3xl title-font font-bold mb-1 bg-gray-300 animate-pulse h-10 w-1/2"></h1>
                    <p class="leading-relaxed bg-gray-300 animate-pulse h-20 w-full"></p>
                    <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">
                        <div class="flex items-center w-full justify-between">
                            <div class="flex items-center">
                                <span class="mr-3 bg-gray-300 animate-pulse h-5 w-16"></span>
                                <div class="rounded border appearance-none py-2 focus:outline-none focus:ring-2 focus:ring-white text-black pl-3 pr-10 bg-gray-300 animate-pulse h-10 w-1/4"></div>
                            </div>
                            <span class="flex items-center bg-gray-300 animate-pulse h-5 w-24"></span>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <span class="title-font font-medium text-2xl bg-gray-300 animate-pulse h-10 w-1/4"></span>
                        <div class="font-semibold text-black px-4 py-2 rounded-md bg-gray-300 animate-pulse h-12 w-32"></div>
                    </div>
                </div>
            </div>
        `;

        this.container.innerHTML = skeletonHTML;
    }

    render(sneaker, sizes) {
        const sizeOptions = sizes.map(size => `<option value="${size.Size_ID}">${size.Size_Value}</option>`).join('');
        const cart = new Cart();

        this.container.innerHTML = `
            <div class="lg:w-4/5 mx-auto flex justify-between">
                <img id="sneakerImage" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="${sneaker.Sneaker_ImageURL}" alt="${sneaker.Sneaker_Model}">
                <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                    <h2 id="brandName" class="text-3xl font-bold title-font tracking-widest">${sneaker.Sneaker_Brand}</h2>
                    <h1 id="sneakerName" class="text-3xl title-font font-bold mb-1">${sneaker.Sneaker_Model}</h1>
                    <p id="sneakerDescription" class="leading-relaxed">${sneaker.Sneaker_Description}</p>
                    <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">
                        <div class="flex items-center w-full justify-between">
                            <div class="flex items-center">
                                <span class="mr-3">Size</span>
                                <select id="sizeList" class="rounded border appearance-none py-2 focus:outline-none focus:ring-2 focus:ring-white text-black pl-3 pr-10">
                                    ${sizeOptions}
                                </select>
                            </div>
                            <span id="sneakerQuantity" class="flex items-center">Stock: ${sneaker.Sneaker_Stock}</span>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <span id="sneakerPrice" class="title-font font-medium text-2xl">$${sneaker.Sneaker_Price}</span>
                        <button id="addToCart" class="bg-white font-semibold text-black px-4 py-2 rounded-md hover:bg-black hover:text-white hover:ring hover:ring-white transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        `;

        const sneakerId = sneaker.Sneaker_ID;

        document.getElementById('addToCart').addEventListener('click', async function() {
            const sizeId = document.getElementById('sizeList').value;
            const price = document.getElementById('sneakerPrice').innerText.replace('$', '');
            await cart.addToCart(sneakerId, sizeId, parseInt(price));
        });
    }
}

export default SneakerDetails;
