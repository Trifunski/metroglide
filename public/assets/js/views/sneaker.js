import SneakerDetails from '../components/sneakerDetails.js';
import Cart from '../components/cart.js';


document.addEventListener("DOMContentLoaded", function() {
    
    const sneakerDetails = new SneakerDetails();
    const cart = new Cart();
    const sneakerId = new URLSearchParams(window.location.search).get('id');
    
    if (sneakerId) {
        sneakerDetails.loadSneaker(sneakerId);
    }

    document.getElementById('addCartButton').addEventListener('click', function() {
        const sizeId = document.getElementById('sizeList').value;
        const token = document.getElementById('userToken').innerText.trim();
        cart.addToCart(sneakerId, sizeId, token);
        location.reload();
    });

});