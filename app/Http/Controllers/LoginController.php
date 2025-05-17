<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function efetuarLogin(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
    
        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('api-token')->plainTextToken;
        } else {
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'sucesso' => true,
            'token' => $token
        ]);
    }

    public function getPerfil(Request $request) {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
