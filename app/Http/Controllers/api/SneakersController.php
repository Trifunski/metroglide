<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sneaker;
use Illuminate\Support\Facades\Log;

class SneakersController extends Controller
{
    private $sneaker;

    public function __construct()
    {
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
        $data = $request->all();
        return response()->json($this->sneaker->store($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->sneaker->update($id, $data));
    }

    public function destroy($id)
    {
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
