<?php

namespace App\Http\Controllers\api\auth;

/**
 * @OA\Info(
 *     title="Nama API Kamu",
 *     version="1.0.0",
 *     description="Deskripsi singkat API kamu"
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 */

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login User.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */

     /**
 * @OA\Post(
 *     path="/api/login",
 *     summary="Login user",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="password123"),
 *             @OA\Property(property="remember", type="boolean", example=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login Successful"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid Credentials"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation Failed"
 *     )
 * )
 */

    public function login(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                "email" => "required|email",
                "password" => "required|string|min:8",
                "remember" => "boolean|nullable",
            ]
        );

        if ($validated->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation Failed",
                "errors" => $validated->errors()
            ], 422);
        } else {
            if (Auth::attempt($validated->validated(), $validated->getValue("remeber"))) {
                $user = User::query()->firstWhere("email", $validated->getValue("email"));
                $token = $user->createToken('auth_token_gasgawe')->plainTextToken;

                return response()->json([
                    "status" => "success",
                    "message" => "Login Successful",
                    "data" => [
                        "user" => $user,
                        "token" => $token
                    ]
                ], 200);
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Invalid Credentials"
                ], 401);
            }
        }
    }

    /**
     * Register User.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                "email" => "required|email|unique:users,email",
                "password" => "required|confirmed|string|min:8",
                "name" => "required|string|max:255",
            ]
        );

        if ($validated->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation Failed",
                "errors" => $validated->errors()
            ], 422);
        } else {
            $user = User::create([
                "email" => $validated->getValue("email"),
                "password" => bcrypt($validated->getValue("password")),
                "name" => $validated->getValue("name"),
            ]);
            if ($user) {
                $token = $user->createToken('auth_token_gasgawe')->plainTextToken;
                return response()->json([
                    "status" => "success",
                    "message" => "Registration Successful",
                    "data" => [
                        "user" => $user,
                        "token" => $token
                    ]
                ], 201);
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Registration Failed"
                ], 500);
            }
        }
    }


    /**
     * Get User.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        if ($request?->user()) {
            return response()->json([
                "status" => "success",
                "data" => $request->user()
            ], 200);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "User not authenticated"
            ], 401);
        }
    }

    /**
     * Logout User.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                "status" => "success",
                "message" => "Logout Successful"
            ], 200);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "User not authenticated"
            ], 401);
        }
    }
}
