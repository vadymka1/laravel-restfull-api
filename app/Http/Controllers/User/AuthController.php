<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTFactory;
use JWTAuth;

class AuthController extends Controller
{
    /**
     * Login logic
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    /**
     * Logout logic
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $token = $request->header('Authorization');

        try {
            JWTAuth::invalidate($token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, invalid token'
            ], 500);
        }
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $request['password'] = Hash::make($request['password'] );

        $user = User::create($request->all());
        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token, 'user' => $user]);
    }

    /**
     * Check token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkAuthUser(Request $request)
    {
        if($token = $request->header('Authorization')){

            try {
                JWTAuth::parseToken()->authenticate();

                return response()->json(['auth' => true]);
            } catch (JWTException $exception) {
                return response()->json([
                    'auth' => false,
                    'message' => 'Invalid token'
                ], 500);
            }

        };

        return response()->json(['auth' => false]);
    }
}
