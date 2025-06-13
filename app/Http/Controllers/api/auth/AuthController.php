<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;

class AuthController extends Controller
{
    /**
     * Login User.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function login(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                "email" => "required|email",
                "password" => "required|string|min:8",
                "remember" => "boolean|nullable",
                "type" => "required|string",
                "device_token" => "sometimes|string",
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
                $user = User::query()->where("email", $validated->getValue("email"))->where('type', $validated->getValue("type"))->first();

                $token = $user->createToken('auth_token_gasgawe')->plainTextToken;

                $user->update([
                    "device_token" => $validated->getValue("device_token") ?? null
                ]);

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

    public function login_with_google(Request $request) {
        $validated = Validator::make(
            $request->all(),
            [
                "type" => "required|string",
                "device_token" => "sometimes|string",
                "provider_token" => "required",
            ]
        );

        if ($validated->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation Failed",
                "errors" => $validated->errors()
            ], 422);
        } else {
            $idToken = $validated->getValue("provider_token");
            $auth = (new Factory)
                ->withServiceAccount(storage_path('firebase_credentials.json'))
                ->createAuth();
    
            $verifiedIdToken = $auth->verifyIdToken($idToken);
    
            $uid = $verifiedIdToken->claims()->get('sub');
            $firebaseUser = $auth->getUser($uid);

            // Find or create user based on Firebase email
            $user = User::firstOrCreate(
                ['email' => $firebaseUser->email],
                [
                    'email' => $firebaseUser->email,
                    'name' => $firebaseUser->displayName ?? $firebaseUser->email,
                    'password' => bcrypt($firebaseUser->uid),
                    'type' => $validated->getValue("type"),
                ]
            );

            $user->update(['device_token' => $request->device_token]);
            $token = $user->createToken('auth_token_gasgawe')->plainTextToken;
    
            Auth::login($user);
            return response()->json([
                "status" => "success",
                "message" => "Login Successful",
                "data" => [
                    "user" => $user,
                    "token" => $token
                ]
            ], 200);
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
                "type" => "required|in:admin,recruiter,candidate",
                "device_token" => "sometimes|string",
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
                "type" => $validated->getValue("type"),
                "device_token" => $validated->getValue("device_token") ?? null,
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
