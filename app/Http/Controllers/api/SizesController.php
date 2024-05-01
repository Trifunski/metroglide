<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\Token;

class SizesController extends Controller
{
    private $size;
    private $token;

    public function __construct()
    {
        $this->size = new Size();
        session_start(); // Iniciar sesión PHP
        $this->token = $_SESSION['token'] ?? null; // Usar la superglobal $_SESSION
    }

    public function index()
    {
        return response()->json($this->size->getSizes());
    }

    public function show($id)
    {
        return response()->json($this->size->getSizeById($id));
    }

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
