<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $user = User::create($data);


        $token = $user->createToken('APP_TOKEN')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required | string | email',
            'password' => 'required | string ',
        ]);
        // Check Emails
        $user = User::where('email',$request->email)->first();
        // Check Password
        if(!$user || !Hash::check($request->password, $user->password)){
            return $response = [
                'message' => "Incorrect Password or Email"
            ];
            return response($response, 401);
        }

        $token = $user->createToken('APP_TOKEN')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function logout(Request $request){
       Auth::user()->tokens()->delete();

        return [
            'message' => "Logged Out"
        ];
    }
}
