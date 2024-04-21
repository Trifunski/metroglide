<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandsController extends Controller
{
    private $brand;

    public function __construct()
    {
        $this->brand = new Brand();
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
        $data = $request->all();
        return response()->json($this->brand->addBrand($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        return response()->json($this->brand->updateBrand($data));
    }

    public function destroy($id)
    {
        return response()->json($this->brand->deleteBrand($id));
    }
}
