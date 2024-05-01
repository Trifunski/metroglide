<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sneaker;
use App\Models\Token;

/**
 * Controlador para manejar las operaciones relacionadas con zapatillas.
 */
class SneakersController extends Controller
{
    /**
     * Instancia del modelo Sneaker.
     * @var Sneaker
     */
    private $sneaker;

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
        $this->sneaker = new Sneaker();
        session_start(); // Iniciar sesión PHP
        $this->token = $_SESSION['token'] ?? null; // Usar la superglobal $_SESSION
    }

    /**
     * Muestra una lista de todas las zapatillas.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->sneaker->index());
    }

    /**
     * Muestra los detalles de una zapatilla específica por ID.
     * @param int $id ID de la zapatilla
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json($this->sneaker->show($id));
    }

    /**
     * Almacena una nueva zapatilla en la base de datos.
     * @param Request $request Datos de la solicitud
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (Token::checkToken($this->token) === false) {
            return response()->json([
                'message' => 'Please log in to add sneakers'
            ]);
        }

        $data = $request->all();
        return response()->json($this->sneaker->store($data));
    }

    /**
     * Actualiza los datos de una zapatilla existente.
     * @param Request $request Datos de la solicitud
     * @param int $id ID de la zapatilla a actualizar
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (Token::checkToken($this->token) === false) {
            return response()->json([
                'message' => 'Please log in to update sneakers'
            ]);
        }

        $data = $request->all();
        return response()->json($this->sneaker->update($id, $data));
    }

    /**
     * Elimina una zapatilla de la base de datos.
     * @param int $id ID de la zapatilla a eliminar
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (Token::checkToken($this->token) === false) {
            return response()->json([
                'message' => 'Please log in to delete sneakers'
            ]);
        }

        return response()->json($this->sneaker->destroy($id));
    }

    /**
     * Muestra una lista de zapatillas filtradas por marca.
     * @param int $brand_id ID de la marca
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexByBrand($brand_id)
    {
        return response()->json($this->sneaker->indexByBrand($brand_id));
    }

    /**
     * Muestra una lista de zapatillas filtradas por talla.
     * @param int $size_id ID de la talla
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexBySize($size_id)
    {
        return response()->json($this->sneaker->indexBySize($size_id));
    }

    /**
     * Filtra zapatillas basado en criterios específicos.
     * @param Request $request Datos de la solicitud
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $data = $request->all();
        return response()->json($this->sneaker->filter($data));
    }
}
