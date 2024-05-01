<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Cart as CartModel;
use App\Models\Sneaker;
use App\Models\Size;

/**
 * Componente de vista para representar y manejar el carrito de compras.
 */
class Cart extends Component
{

    /**
     * @var array Datos del carrito actual en la sesión.
     */
    public $cart;

    /**
     * @var array Detalles del carrito que incluyen información detallada de los productos.
     */
    public $cart_details = [];

    /**
     * @var Sneaker Modelo para gestionar las operaciones relacionadas con zapatillas.
     */
    public $sneaker;

    /**
     * @var Size Modelo para gestionar las operaciones relacionadas con tallas.
     */
    public $size;

    /**
     * @var float Total acumulado del carrito.
     */
    public $total = 0;

    /**
     * Constructor que inicializa las instancias de los modelos y los datos del carrito.
     */
    public function __construct()
    {

        $this->cart = $_SESSION['cart'] ?? [];
        $this->sneaker = new Sneaker();
        $this->size = new Size();

        /* if (!empty($this->cart)) {
            foreach ($this->cart as $key => $value) {
                list($product_id, $size_id) = explode('-', $key);
                $sneaker = $this->sneaker->show($product_id);
                $size = $this->size->getSizeById($size_id);
    
                if ($sneaker && $size) {
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
        } */
        
    }

    /**
     * Renderiza el componente.
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.cart')->with('cart_details', $this->cart_details);
    }
}
