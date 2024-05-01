@php
    $cart = $_SESSION['cart'] ?? [];
    $sneaker = new App\Models\Sneaker();
    $size = new App\Models\Size();
    $cart_details = [];

    $total = 0;
    foreach ($cart as $key => $value) {
        list($product_id, $size_id) = explode('-', $key);
        $sneakerData = $sneaker->show($product_id);
        $sizeData = $size->getSizeById($size_id);

        if ($sneakerData && $sizeData) {
            $cart_details[] = [
                'product_id' => $product_id,
                'size_id' => $size_id,
                'sneaker_img' => $sneakerData['Sneaker_ImageURL'],
                'sneaker_model' => $sneakerData['Sneaker_Model'],
                'size' => $sizeData['Size_Value'],
                'sneaker_price' => $sneakerData['Sneaker_Price'],
                'quantity' => $value['quantity'],
            ];
            $total += $sneakerData['Sneaker_Price'] * $value['quantity'];
        }
    }
@endphp

<div id="cartContainer" class="container mx-auto shadow-lg my-8 p-6 rounded-lg flex justify-center">

    @if (count($cart_details) == 0 || $cart_details == null)
        <div class="text-center text-white">
            <h1 class="text-2xl font-semibold">Your cart is empty</h1>
            <a href="/" class="text-white hover:underline">Continue shopping</a>
        </div>
    @else 
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-300 bg-black text-left text-sm font-semibold text-white uppercase tracking-wider">
                        
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-300 bg-black text-left text-sm font-semibold text-white uppercase tracking-wider">
                        Model
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-300 bg-black text-left text-sm font-semibold text-white uppercase tracking-wider">
                        Size
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-300 bg-black text-left text-sm font-semibold text-white uppercase tracking-wider">
                        Quantity
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-300 bg-black text-left text-sm font-semibold text-white uppercase tracking-wider">
                        Price
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-300 bg-black text-left text-sm font-semibold text-white uppercase tracking-wider">
                        Accion
                    </th>
                </tr>
            </thead>
            <tbody id="cartItems">
                @foreach($cart_details as $item)
                    <tr>
                        <td class="px-5 py-4 border-b border-gray-200 bg-black text-white text-sm">
                            <img src="{{ $item['sneaker_img'] }}" alt="{{ $item['sneaker_model'] }}" class="h-24 w-auto">
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-black text-white text-sm">
                            {{ $item['sneaker_model'] }}
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-black text-white text-sm">
                            {{ $item['size'] }}
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 text-black bg-black text-sm">
                            <input type="number" class="quantity-input rounded-lg" value="{{ $item['quantity'] }}" min="1" max="{{ $item['quantity'] }}">
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-black text-white text-sm">
                            ${{ number_format($item['sneaker_price'], 2) }}
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-black text-white text-sm">
                            <button class="bg-white font-semibold text-black px-4 py-2 rounded-md hover:bg-black hover:text-white hover:ring hover:ring-white transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 delete-button" data-product-id="{{ $item['product_id'] }}" data-product-size="{{ $item['size_id'] }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6" class="px-5 py-4 border-b border-gray-200 bg-black text-sm">
                        <div class="flex justify-end items-center w-full mt-2">
                            <span class="font-semibold text-white mr-2">Total:</span>
                            <span class="text-white">${{ number_format($total, 2) }}</span>
                            <button id="checkoutButton" class="bg-white font-semibold text-black px-4 py-2 rounded-md hover:bg-black hover:text-white hover:ring hover:ring-white transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 ml-3 checkout-button">Checkout</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
</div>
