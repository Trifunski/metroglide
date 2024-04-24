import Cart from '../components/cart.js';

var cart = new Cart();

document.addEventListener("DOMContentLoaded", function () {

    const deleteButtons = document.querySelectorAll(".delete-button");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const id = button.getAttribute("data-product-id");
            const size = button.getAttribute("data-product-size");
            const row = button.closest("tr");
            const quantityInputs = row.querySelector(".quantity-input");

            cart.removeFromCart(id, size, quantityInputs.value);
        });
    });
    
}); 