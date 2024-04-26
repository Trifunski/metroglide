import APIHandler from "../api/apiHandler.js";

class Cart {
    constructor()  {
        this.api = new APIHandler('');
    }

    async addToCart(sneakerId, sizeId, price) {
        try {
            await this.api.addToCart(sneakerId, sizeId, price);
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

    async checkout() {
        try {
            const checkout = await this.api.checkout();
            cartContainer.innerHTML = '';
            const checkoutForm = document.createElement('form');   
    
            // Agregar los productos y detalles del formulario al HTML
            checkoutForm.innerHTML = `
                <div class="flex items-center py-4 px-4 lg:px-20 xl:px-32">
                    <div class="bg-white rounded px-4 pt-8">
                        <p class="text-xl font-medium">Payment Details</p>
                        <p class="text-gray-400">Complete your order by providing your payment details.</p>
                        <div>
                            <label for="email" class="mt-4 mb-2 block text-sm font-medium">Email</label>
                            <div class="relative">
                                <input type="text" id="email" name="email" class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:border-blue-500 focus:ring-blue-500" placeholder="your.email@gmail.com" />
                            </div>
                            <label for="card-holder" class="mt-4 mb-2 block text-sm font-medium">Card Holder</label>
                            <div class="relative">
                                <input type="text" id="card-holder" name="card-holder" class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:border-blue-500 focus:ring-blue-500" placeholder="Full Name" />
                            </div>
                            <label for="card-no" class="mt-4 mb-2 block text-sm font-medium">Card Details</label>
                            <div class="flex flex-wrap gap-2">
                                <input type="text" id="card-no" name="card-no" class="flex-grow rounded-md border border-gray-200 px-2 py-3 text-sm shadow-sm outline-none focus:border-blue-500 focus:ring-blue-500" placeholder="xxxx-xxxx-xxxx-xxxx" />
                                <input type="text" name="credit-expiry" class="flex-grow rounded-md border border-gray-200 px-2 py-3 text-sm shadow-sm outline-none focus:border-blue-500 focus:ring-blue-500" placeholder="MM/YY" />
                                <input type="text" name="credit-cvc" class="w-1/4 rounded-md border border-gray-200 px-2 py-3 text-sm shadow-sm outline-none focus:border-blue-500 focus:ring-blue-500" placeholder="CVC" />
                            </div>
                            <label for="billing-address" class="mt-4 mb-2 block text-sm font-medium">Billing Address</label>
                            <div class="flex flex-wrap gap-2">
                                <input type="text" id="billing-address" name="billing-address" class="flex-grow rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:border-blue-500 focus:ring-blue-500" placeholder="Street Address" />
                                <input type="text" name="billing-state" class="flex-grow rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:border-blue-500 focus:ring-blue-500" placeholder="City" />
                                <input type="text" name="billing-zip" class="w-1/4 rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:border-blue-500 focus:ring-blue-500" placeholder="ZIP" />
                            </div>
                            <div class="mt-6 flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">Total</p>
                                <p class="text-2xl font-semibold text-gray-900">$${parseFloat(checkout.total).toFixed(2)}</p>
                            </div>
                            <button class="mt-4 mb-8 w-full rounded-md bg-black px-6 py-3 font-medium text-white transition duration-300 hover:scale-105">Complete Order</button>
                        </div>
                    </div>
                </div>
            `;
            cartContainer.appendChild(checkoutForm);

            checkoutForm.addEventListener('submit', async (event) => {
                event.preventDefault();
            
                try {
                    await this.api.completedOrder();
                    alert('Order completed successfully.');
                    window.location.reload();
                } catch (error) {
                    console.error('Error completing order:', error.message);
                    alert('Failed to complete order.');
                }
            });
    
        } catch (error) {
            console.error('Error checking out:', error.message);
            alert('Failed to checkout.');
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