<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function create(Request $request)
    {
        $role = Role::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Success'
        ]);
    }
}
