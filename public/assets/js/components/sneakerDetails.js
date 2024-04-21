import APIHandler from '../api/apiHandler.js';

class SneakerDetails {
    constructor() {
        this.imageURL = document.getElementById('sneakerImage');
        this.brandName = document.getElementById('brandName');
        this.sneakerName = document.getElementById('sneakerName');
        this.sneakerDescription = document.getElementById('sneakerDescription');
        this.sneakerPrice = document.getElementById('sneakerPrice');
        this.sizeList = document.getElementById('sizeList');
        this.sneakerQuantity = document.getElementById('sneakerQuantity');

        this.api = new APIHandler('/api/adrian');
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

    render(sneaker, sizes) {
        const sizeOptions = sizes.map(size => `<option value="${size.Size_ID}">${size.Size_Value}</option>`).join('');
        this.imageURL.src = sneaker.Sneaker_ImageURL;
        this.brandName.textContent = sneaker.Sneaker_Model;
        this.sneakerName.textContent = sneaker.Sneaker_Name;
        this.sneakerDescription.textContent = sneaker.Sneaker_Description;
        this.sneakerPrice.textContent = `$${sneaker.Sneaker_Price}`;
        this.sneakerQuantity.textContent = `Stock: ${sneaker.Sneaker_Stock}`;
        this.sizeList.innerHTML = sizeOptions;
    }
}

export default SneakerDetails;
