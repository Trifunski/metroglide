<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sneaker;
use App\Models\Token;

class SneakersController extends Controller
{
    private $sneaker;
    private $token;

    public function __construct()
    {       
        $this->token = session()->get('token');
        $this->sneaker = new Sneaker();
    }

    public function index()
    {
        return response()->json($this->sneaker->index());
    }

    public function show($id)
    {
        return response()->json($this->sneaker->show($id));
    }

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

    public function destroy($id)
    {

        if (Token::checkToken($this->token) === false) {
            return response()->json([
                'message' => 'Please log in to delete sneakers'
            ]);
        }

        return response()->json($this->sneaker->destroy($id));
    }

    public function indexByBrand($brand_id)
    {
        return response()->json($this->sneaker->indexByBrand($brand_id));
    }

    public function indexBySize($size_id)
    {
        return response()->json($this->sneaker->indexBySize($size_id));
    }

    public function filter(Request $request)
    {
        $data = $request->all();
        return response()->json($this->sneaker->filter($data));
    }
}
