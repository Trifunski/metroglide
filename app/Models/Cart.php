<?php

namespace App\Models;

use App\Models\Database;
use App\Models\Sneaker;
use App\Models\Size;

/**
 * Modelo Cart para gestionar las operaciones del carrito de compras.
 */
class Cart
{
    /**
     * @var Database Instancia de la base de datos.
     */
    private $db;

    /**
     * Constructor que inicializa la instancia de la base de datos.
     */
    function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Retorna el carrito actual de la sesión.
     * @return array El carrito de la sesión actual.
     */
    public static function getCart()
    {
        return $_SESSION['cart'] ?? [];
    }

    /**
     * Realiza el proceso de pago del carrito actual, calculando totales y devolviendo detalles.
     * @return array Detalles del carrito incluyendo productos, tallas y total.
     */
    public static function checkout() 
    {
        $cart = self::getCart();
        $products = [];
        $sizes = [];
        $total = 0;
    
        if ($cart) {
            $sneaker = new Sneaker();
            $size = new Size();
    
            foreach ($cart as $item) {
                $productId = $item['product_id'];
                $sizeId = $item['size_id'];
                $quantity = $item['quantity'];
    
                $productDetail = $sneaker->show($productId);
                if ($productDetail) {
                    $products[] = $productDetail;
                    $pricePerUnit = $productDetail['Sneaker_Price'];
                    $total += $pricePerUnit * $quantity;
                }
    
                $sizeDetail = $size->getSizeById($sizeId);
                if ($sizeDetail) {
                    $sizes[] = $sizeDetail;
                }
            }
        }
    
        return [
            'products' => $products,
            'sizes' => $sizes,
            'total' => $total
        ];
    }

    /**
     * Agrega un producto al carrito de la sesión.
     * @param int $product_id ID del producto.
     * @param int $user_id ID del usuario.
     * @param int $size_id ID de la talla.
     * @param int $quantity Cantidad del producto.
     * @param float $price Precio del producto.
     */
    public static function addCart($product_id, $user_id, $size_id, $quantity, $price)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    
        $cart = $_SESSION['cart'];
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
    
        $_SESSION['cart'] = $cart;
    }

    /**
     * Elimina un producto del carrito de la sesión.
     * @param int $product_id ID del producto.
     * @param int $size_id ID de la talla.
     * @param int $quantity Cantidad del producto.
     */
    public static function removeCart($product_id, $size_id, $quantity)
    {
        $cart = $_SESSION['cart'];
    
        $product_key = $product_id . '-' . $size_id;
    
        if (isset($cart[$product_key])) {
            $cart[$product_key]['quantity'] -= $quantity;
            if ($cart[$product_key]['quantity'] <= 0) {
                unset($cart[$product_key]);
            }
        }
    
        $_SESSION['cart'] = $cart;
    }

    /**
     * Actualiza la cantidad de un producto en el carrito de la sesión.
     * @param int $product_id ID del producto.
     * @param int $quantity Cantidad del producto.
     */
    public static function updateCart($product_id, $quantity)
    {
        $cart = $_SESSION['cart'];

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] = $quantity;
        }

        $_SESSION['cart'] = $cart;
    }

    /**
     * Limpia el carrito de la sesión.
     */
    public static function clearCart()
    {
        unset($_SESSION['cart']);
    }

    /**
     * Guarda el carrito actual en la base de datos.
     */
    public function saveCartToDatabase()
    {
        $cart = $_SESSION['cart'] ?? [];
    
        if ($cart) {
            $sqlInsertCart = "INSERT INTO Carts (User_ID, Cart_Created_At) VALUES (?, ?)";
            $userId = $_SESSION['user_id'] ?? null;
            $createdAt = date('Y-m-d H:i:s');
            $this->db->execute($sqlInsertCart, [$userId, $createdAt]);
            $cartId = $this->db->lastInsertId();
    
            $sneaker = new Sneaker();
            $size = new Size();
    
            foreach ($cart as $item) {
                $product = $sneaker->show($item['product_id']);
                $sizeDetail = $size->getSizeById($item['size_id']);

                $sqlInsertDetails = "INSERT INTO Cart_details (Cart_ID, Sneaker_ID, Size_ID, Cart_Quantity, Price_Per_Unit) VALUES (?, ?, ?, ?, ?)";
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

    /**
     * Obtiene el carrito de la base de datos para un usuario específico.
     * @param int $userId ID del usuario.
     * @return array El carrito de la base de datos.
     */
    public function getCartFromDatabase($userId)
    {
        $sql = "SELECT cd.* FROM Cart_Details cd JOIN (SELECT Cart_ID FROM Carts WHERE User_ID = ? ORDER BY Cart_Created_At DESC LIMIT 1) AS last_cart ON cd.Cart_ID = last_cart.Cart_ID";

        $cart = $this->db->fetchAll($sql, [$userId]);

        return $cart;
    }

    /**
     * Guarda el carrito de la base de datos en la sesión.
     * @param array $cart El carrito de la base de datos.
     */
    public static function saveCheckoutToDatabase($userId)
    {
        $cart = $_SESSION['cart'];

        if ($cart) {
            $sqlInsertOrder = "INSERT INTO Orders (User_ID, Order_Date, Order_Total) VALUES (?, ?, ?)";
            $createdAt = date('Y-m-d H:i:s');
            $total = 0;

            foreach ($cart as $item) {
                $total += $item['quantity'] * $item['price_per_unit'];
            }

            $db = new Database();
            $db->execute($sqlInsertOrder, [$userId, $createdAt, $total]);
            $orderId = $db->lastInsertId();

            $sqlInsertOrderDetails = "INSERT INTO Order_details (Order_ID, Sneaker_ID, Size_ID, Order_Quantity, Price_Per_Unit) VALUES (?, ?, ?, ?, ?)";

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