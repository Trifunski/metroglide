import APIHandler from "../api/apiHandler.js";

class Cart {
    constructor()  {
        this.api = new APIHandler('');
    }

    async addToCart(sneakerId, sizeId) {
        try {
            await this.api.addToCart(sneakerId, sizeId);
            alert('Item added to cart.');
        } catch (error) {
            console.error('Error adding item to cart:', error.message);
            alert('Failed to add item to cart.');
        }
    }

    async removeFromCart(sneakerId, sizeId, quantity) {
        try {
            await this.api.removeFromCart(sneakerId, sizeId, quantity);
            window.location.reload(); 
        } catch (error) {
            console.error('Error removing item from cart:', error.message);
            alert('Failed to remove item from cart.');
        }
    }

    async loadCart() {
        try {
            const cart = await this.api.fetchCart();
            this.render(cart);
        } catch (error) {
            console.error('Error loading cart:', error.message);
            alert('Failed to load cart.');
        }
    }

    render(cart) {
        console.log(cart);
        const cartList = document.getElementById('cartList');

        const cartItems = cart.map(item => `
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">${item.Sneaker_Name}</h6>
                    <small class="text-muted">${item.Size_Value}</small>
                </div>
                <span class="text-muted">$${item.Sneaker_Price}</span>
            </li>
        `).join('');

        cartList.innerHTML = cartItems;

        const totalPrice = cart.reduce((total, item) => total + item.Sneaker_Price, 0);
        const cartTotal = document.getElementById('cartTotal');
        cartTotal.textContent = `$${totalPrice}`;

    }

}

export default Cart;