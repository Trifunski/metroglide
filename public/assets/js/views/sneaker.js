import SneakerDetails from '../components/sneakerDetails.js';
import Cart from '../components/cart.js';

document.addEventListener("DOMContentLoaded", function() {
    
    const sneakerDetails = new SneakerDetails();
    const cart = new Cart();
    const sneakerId = new URLSearchParams(window.location.search).get('id');
    
    if (sneakerId) {
        sneakerDetails.loadSneaker(sneakerId);
    }

    document.getElementById('addToCart').addEventListener('click', async function() {
        const sizeId = document.getElementById('sizeList').value;
        const price = document.getElementById('sneakerPrice').innerText.replace('$', '');
        await cart.addToCart(sneakerId, sizeId, parseInt(price));
    });

});