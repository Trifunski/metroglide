<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\Token;

/**
 * Controlador para manejar las operaciones relacionadas con tallas de zapatillas.
 */
class SizesController extends Controller
{
    /**
     * Instancia del modelo Size.
     * @var Size
     */
    private $size;

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
        $this->size = new Size();
        session_start(); // Iniciar sesión PHP
        $this->token = $_SESSION['token'] ?? null; // Usar la superglobal $_SESSION
    }

    /**
     * Muestra una lista de todas las tallas disponibles.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->size->getSizes());
    }

    /**
     * Muestra los detalles de una talla específica por ID.
     * @param int $id ID de la talla
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json($this->size->getSizeById($id));
    }

    /**
     * Almacena una nueva talla en la base de datos.
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
        return response()->json($this->size->addSize($data));
    }

    /**
     * Actualiza los datos de una talla existente.
     * @param Request $request Datos de la solicitud
     * @param int $id ID de la talla a actualizar
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (Token::checkToken($this->token) === false) {
            return response()->json([
                'message' => 'Please log in to add sneakers'
            ]);
        }

        $data = $request->all();
        $data['id'] = $id;
        return response()->json($this->size->updateSize($data));
    }

    /**
     * Elimina una talla de la base de datos.
     * @param int $id ID de la talla a eliminar
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (Token::checkToken($this->token) === false) {
            return response()->json([
                'message' => 'Please log in to add sneakers'
            ]);
        }

        return response()->json($this->size->deleteSize($id));
    }
}
