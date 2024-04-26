<?php

namespace App\Models;

use App\Models\Database;
use App\Models\Sneaker;
use App\Models\Size;
use Illuminate\Support\Facades\Log;

class Cart
{

    private $db;

    function __construct()
    {
        $this->db = new Database();
    }

    public static function getCart()
    {
        return session()->get('cart');
    }

    public static function checkout() 
    {
        $cart = self::getCart();
        $products = [];
        $sizes = [];
        $total = 0;  // Inicializar total
    
        if ($cart) {
            $sneaker = new Sneaker();
            $size = new Size();
    
            // Centralizar la obtención de detalles y calcular el total
            foreach ($cart as $item) {
                $productId = $item['product_id'];
                $sizeId = $item['size_id'];
                $quantity = $item['quantity'];  // Asumiendo que la cantidad está en el carrito
    
                // Obtener detalles del producto
                $productDetail = $sneaker->show($productId);
                if ($productDetail) {
                    $products[] = $productDetail;
                    $pricePerUnit = $productDetail['Sneaker_Price'];  // Asumiendo que el precio está en los detalles del producto
                    $total += $pricePerUnit * $quantity;  // Sumar al total
                }
    
                // Obtener detalles del tamaño
                $sizeDetail = $size->getSizeById($sizeId);
                if ($sizeDetail) {
                    $sizes[] = $sizeDetail;
                }
            }
        }
    
        return [
            'products' => $products,
            'sizes' => $sizes,
            'total' => $total  // Devolver el total calculado
        ];
    }                       

    public static function addCart($product_id, $user_id, $size_id, $quantity, $price)
    {
        if (!session()->has('cart')) {
            session()->put('cart', []);
        }
    
        $cart = session()->get('cart');
    
        $product_key = $product_id . '-' . $size_id;

        if (isset($cart[$product_key])) {
            $cart[$product_key]['quantity'] += $quantity;
        } else {
            $cart[$product_key] = [
                'product_id' => $product_id,
                'user_id' => $user_id,
                'size_id' => $size_id,
                'quantity' => $quantity,
                'price_per_unit' => $price
            ];
        }
    
        session()->put('cart', $cart);
    }    

    public static function removeCart($product_id, $size_id, $quantity)
    {
        $cart = session()->get('cart');
    
        $product_key = $product_id . '-' . $size_id;
    
        if (isset($cart[$product_key])) {
            $cart[$product_key]['quantity'] -= $quantity;
            if ($cart[$product_key]['quantity'] <= 0) {
                unset($cart[$product_key]);
            }
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

    public static function clearCart()
    {
        session()->forget('cart');
    }

    public function saveCartToDatabase()
    {
        $cart = session()->get('cart');
    
        if ($cart) {
            $sqlInsertCart = "INSERT INTO carts (User_ID, Cart_Created_At) VALUES (?, ?)";
            $userId = session('user_id');
            $createdAt = date('Y-m-d H:i:s');
            $this->db->execute($sqlInsertCart, [$userId, $createdAt]);
            $cartId = $this->db->lastInsertId();
    
            $sneaker = new Sneaker();
            $size = new Size();
    
            foreach ($cart as $item) {
                $product = $sneaker->show($item['product_id']);
                $sizeDetail = $size->getSizeById($item['size_id']);

                $sqlInsertDetails = "INSERT INTO cart_details (Cart_ID, Sneaker_ID, Size_ID, Cart_Quantity, Price_Per_Unit) VALUES (?, ?, ?, ?, ?)";
                $this->db->execute($sqlInsertDetails, [
                    $cartId,
                    $item['product_id'],
                    $item['size_id'],
                    $item['quantity'],
                    $product['Sneaker_Price']
                ]);
            }
        }
    }

    public function getCartFromDatabase($userId)
    {
        $sql = "SELECT cd.* FROM Cart_Details cd JOIN (SELECT Cart_ID FROM Carts WHERE User_ID = ? ORDER BY Cart_Created_At DESC LIMIT 1) AS last_cart ON cd.Cart_ID = last_cart.Cart_ID";

        $cart = $this->db->fetchAll($sql, [$userId]);

        return $cart;
    }

    public static function saveCheckoutToDatabase($userId)
    {
        $cart = session()->get('cart');

        if ($cart) {
            $sqlInsertOrder = "INSERT INTO orders (User_ID, Order_Date, Order_Total) VALUES (?, ?, ?)";
            $createdAt = date('Y-m-d H:i:s');
            $total = 0;

            foreach ($cart as $item) {
                $total += $item['quantity'] * $item['price_per_unit'];
            }

            $db = new Database();
            $db->execute($sqlInsertOrder, [$userId, $createdAt, $total]);
            $orderId = $db->lastInsertId();

            $sqlInsertOrderDetails = "INSERT INTO order_details (Order_ID, Sneaker_ID, Size_ID, Order_Quantity, Price_Per_Unit) VALUES (?, ?, ?, ?, ?)";

            foreach ($cart as $item) {
                $db->execute($sqlInsertOrderDetails, [
                    $orderId,
                    $item['product_id'],
                    $item['size_id'],
                    $item['quantity'],
                    $item['price_per_unit']
                ]);
            }

        }

        return json_encode(['message' => 'Order completed']);
    }

}