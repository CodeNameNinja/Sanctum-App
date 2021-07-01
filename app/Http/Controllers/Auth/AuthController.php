<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request){
       $request->validate([
            'name' => 'required | string',
            'email' => 'required | string | unique:users,email',
            'password' => 'required | string | confirmed | min:8',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $user = User::create($request->all());


        $token = $user->createToken('APP_TOKEN')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function login(Request $request){

    }
}
