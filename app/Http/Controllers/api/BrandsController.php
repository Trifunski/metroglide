<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Token;

/**
 * Controlador para manejar las operaciones relacionadas con marcas.
 */
class BrandsController extends Controller
{
    /**
     * Instancia del modelo Brand.
     * @var Brand
     */
    private $brand;

    /**
     * Token de la sesión actual.
     * @var string|null
     */
    private $token;

    /**
     * Constructor que inicializa las instancias de modelo y verifica la sesión.
     */
    public function __construct()
    {
        $this->brand = new Brand();
        session_start(); // Asegurar que la sesión está iniciada
        $this->token = $_SESSION['token'] ?? null; // Uso de la superglobal $_SESSION
    }

    /**
     * Muestra una lista de todas las marcas.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->brand->getBrands());
    }

    /**
     * Muestra los detalles de una marca específica.
     * @param int $id ID de la marca
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json($this->brand->getBrandById($id));
    }

    /**
     * Almacena una nueva marca en la base de datos.
     * @param Request $request Datos de la solicitud
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (Token::checkToken($this->token) === false) {
            return response()->json([
                'message' => 'Please log in to add brands'
            ], 401);
        }

        $data = $request->all();
        return response()->json($this->brand->addBrand($data));
    }

    /**
     * Actualiza los datos de una marca existente.
     * @param Request $request Datos de la solicitud
     * @param int $id ID de la marca a actualizar
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (Token::checkToken($this->token) === false) {
            return response()->json([
                'message' => 'Please log in to update brands'
            ], 401);
        }

        $data = $request->all();
        $data['id'] = $id;
        return response()->json($this->brand->updateBrand($data));
    }

    /**
     * Elimina una marca de la base de datos.
     * @param int $id ID de la marca a eliminar
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (Token::checkToken($this->token) === false) {
            return response()->json([
                'message' => 'Please log in to delete brands'
            ], 401);
        }

        return response()->json($this->brand->deleteBrand($id));
    }
}
