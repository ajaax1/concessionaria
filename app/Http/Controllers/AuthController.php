<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use \Illuminate\Http\JsonResponse;
class AuthController extends Controller
{

    private $admin;

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 7200
        ]);
    }

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->admin = new User();
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Email ou senha incorretos'], 401);
        }

        $admin = $this->admin->where('email', $credentials['email'])->first();

        return response()->json([
            'name' => $admin->name,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>  7200
        ]);;
    }
    
    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        $token = auth()->refresh();
        $response = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 7200
        ];
        return response()->json($response);
    }

    public function verify(): JsonResponse{
        return response()->json(['message'=>'Token válido'], 200);
    }

}
