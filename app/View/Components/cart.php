<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Cart as CartModel;
use App\Models\Sneaker;
use App\Models\Size;

class cart extends Component
{

    public $cart;
    public $cart_details;
    public $sneaker;
    public $size;
    public $total = 0;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {

        $this->cart = $_SESSION['cart'] ?? [];
        $this->cart_details = [];
        $this->sneaker = new Sneaker();
        $this->size = new Size();

        if (!empty($this->cart)) {
            foreach ($this->cart as $key => $value) {
                list($product_id, $size_id) = explode('-', $key);
                $sneaker = $this->sneaker->show($product_id);
                $size = $this->size->getSizeById($size_id);
    
                if ($sneaker && $size) { // Asegúrate de que ambos, sneaker y size, existan antes de acceder a sus propiedades
                    $this->cart_details[] = [
                        'product_id' => $product_id,
                        'size_id' => $size_id,
                        'sneaker_img' => $sneaker['Sneaker_ImageURL'],
                        'sneaker_model' => $sneaker['Sneaker_Model'],
                        'size' => $size['Size_Value'],
                        'sneaker_price' => $sneaker['Sneaker_Price'],
                        'quantity' => $value['quantity'],
                    ];
                    $this->total += $sneaker['Sneaker_Price'] * $value['quantity'];
                }
            }
        }
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart');
    }
}
