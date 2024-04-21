<?php

namespace App\Models;

use App\Models\Database;

class Cart
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getCart($user_id)
    {
        $sql = "SELECT ci.product_id, ci.quantity, p.name, p.price
                FROM cart_items ci
                JOIN carts c ON ci.cart_id = c.cart_id
                JOIN products p ON ci.product_id = p.product_id
                WHERE c.user_id = ?";
        return $this->db->fetchAll($sql, [$user_id]);
    }

    public function addToCart($user_id, $product_id, $quantity)
    {
        $sql = "SELECT cart_id FROM carts WHERE user_id = ?";
        $result = $this->db->fetch($sql, [$user_id]);

        if (!result) {
            $sql = "INSERT INTO carts (user_id) VALUES (?)";
            $this->db->execute($sql, [$user_id]);
            $cart_id = $this->db->lastInsertId();
        } else {
            $cart_id = $result['cart_id'];
        }

        $sql = "SELECT cart_item_id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?";
        $item = $this->db->fetch($sql, [$cart_id, $product_id]);

        if ($item) {
            $quantity += $item['quantity'];
            $sql = "UPDATE cart_items SET quantity = ? WHERE cart_item_id = ?";
            $this->db->execute($sql, [$quantity, $item['cart_item_id']]);
        } else {
            $sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)";
            $this->db->execute($sql, [$cart_id, $product_id, $quantity]);
        }
    }

    public static function updateCart($user_id, $product_id, $quantity)
    {
        $sql = "UPDATE cart_items ci
                JOIN carts c ON ci.cart_id = c.cart_id
                SET ci.quantity = ?
                WHERE c.user_id = ? AND ci.product_id = ?";
        $db->execute($sql, [$quantity, $user_id, $product_id]);
    }

    public static function deleteFromCart($user_id, $product_id)
    {
        $sql = "DELETE ci
                FROM cart_items ci
                JOIN carts c ON ci.cart_id = c.cart_id
                WHERE c.user_id = ? AND ci.product_id = ?";
        $db->execute($sql, [$user_id, $product_id]);
    }

    public static function clearCart($user_id)
    {
        $sql = "DELETE ci
                FROM cart_items ci
                JOIN carts c ON ci.cart_id = c.cart_id
                WHERE c.user_id = ?";
        $db->execute($sql, [$user_id]);
    }
    
}
