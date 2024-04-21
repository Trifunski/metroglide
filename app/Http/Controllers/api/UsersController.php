<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        return response()->json($this->user->index());
    }

    public function show($id)
    {
        return response()->json($this->user->show($id));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->user->store($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->user->update($id, $data));
    }

    public function destroy($id)
    {
        return response()->json($this->user->destroy($id));
    }
}
