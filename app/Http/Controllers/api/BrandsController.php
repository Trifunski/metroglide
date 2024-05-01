<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Token;

class BrandsController extends Controller
{
    private $brand;
    private $token;

    public function __construct()
    {
        $this->brand = new Brand();
        session_start(); // Asegurar que la sesión está iniciada
        $this->token = $_SESSION['token'] ?? null; // Uso de la superglobal $_SESSION
    }

    public function index()
    {
        return response()->json($this->brand->getBrands());
    }

    public function show($id)
    {
        return response()->json($this->brand->getBrandById($id));
    }

    public function store(Request $request)
    {
        if (Token::checkToken($this->token) === false) {
            return response()->json([
                'message' => 'Please log in to add brands'
            ], 401); // Indicar también el código de estado HTTP adecuado
        }

        $data = $request->all();
        return response()->json($this->brand->addBrand($data));
    }

    public function update(Request $request, $id)
    {
        if (Token::checkToken($this->token) === false) {
            return response()->json([
                'message' => 'Please log in to update brands'
            ], 401); // Indicar también el código de estado HTTP adecuado
        }

        $data = $request->all();
        $data['id'] = $id;
        return response()->json($this->brand->updateBrand($data));
    }

    public function destroy($id)
    {
        if (Token::checkToken($this->token) === false) {
            return response()->json([
                'message' => 'Please log in to delete brands'
            ], 401); // Indicar también el código de estado HTTP adecuado
        }

        return response()->json($this->brand->deleteBrand($id));
    }
}
