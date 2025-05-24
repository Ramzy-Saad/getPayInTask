<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function update(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $request->user()->id,
            ]);

        $request->user()->update($validated_data);
        return response()->json([
            'data' => new UserResource($request->user())
        ]);
    }
    
}
