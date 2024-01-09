<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function Register(RegisterRequest $request) {
        $payload = $request->validated();

        Hash::make($payload["password"]);

        $user = User::create($payload);

        if ($user) {
            return response()->json(["message" => "Register sukses"], 201);
        }
    }

    function Login(Request $request) {
        $validation = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required" 
         ]);
 
         if ($validation->fails()) {
             return response()->json($validation->errors(), 401);
         }

         $user = User::firstWhere("email", $request->email);

         if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("auth_token")->plainTextToken;

                return response()->json([
                    "message" => "Login berhasil",
                    "user" => $user,
                    "token" => $token
                ], 200);
            } else {
                return response()->json([
                    "message" => "Password salah"
                ], 401);
            }
         } else {
            return response()->json([
                "message" => "Akun tidak terdaftar"
            ], 404);
         }
    }
}
