<?php

namespace App\Models;

use App\Models\Database;

class Cart
{

    public static function addCart($product_id, $user_id, $size_id, $quantity)
    {
        if (!session()->has('cart')) {
            session()->put('cart', []);
        }

        $cart = session()->get('cart');

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += $quantity;
        } else {
            $cart[$product_id] = [
                'product_id' => $product_id,
                'user_id' => $user_id,
                'size_id' => $size_id,
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $cart);
    }

    public static function removeCart($product_id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
        }

        session()->put('cart', $cart);
    }

    public static function updateCart($product_id, $quantity)
    {
        $cart = session()->get('cart');

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);
    }

    public static function getCart()
    {
        return session()->get('cart');
    }

    public static function clearCart()
    {
        session()->forget('cart');
    }

    public static function saveCartToDatabase($user_id)
    {
        $cart = session()->get('cart');

        foreach ($cart as $product_id => $item) {
            $query = "INSERT INTO Carts (Product_ID, User_ID, Size_ID, Quantity) VALUES (?, ?, ?, ?)"; 
            $db = new Database();
            $db->execute($query, [$product_id, $user_id, $item['size_id'], $item['quantity']]);
        }

        session()->forget('cart');
    }

}