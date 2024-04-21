<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;

class SizesController extends Controller
{
    private $size;

    public function __construct()
    {
        $this->size = new Size();
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
        $data = $request->all();
        return response()->json($this->size->addSize($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return response()->json($this->size->updateSize($data));
    }

    public function destroy($id)
    {
        return response()->json($this->size->deleteSize($id));
    }
}
