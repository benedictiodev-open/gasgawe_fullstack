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

     /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     summary="Login",
     *     description="Portal login menggunakan email dan password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password","type"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="remember", type="boolean", example=false),
     *             @OA\Property(property="type", type="string", example="applicant"),
     *             @OA\Property(property="device_token", type="string", example="device_token_example")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Login Successful"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object"),
     *                 @OA\Property(property="token", type="string", example="token123")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid Credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Invalid Credentials")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Failed"),
     *             @OA\Property(property="errors", type="object")
     *         )
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
            $credentials = [
                'email' => $validated->getValue('email'),
                'password' => $validated->getValue('password'),
                'type' => $validated->getValue('type'),
            ];
            $remember = $validated->getValue('remember', false);

            if (Auth::attempt($credentials, $remember)) {
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

    /**
     * @OA\Post(
     *     path="/login-with-google",
     *     tags={"Auth"},
     *     summary="Login with Google",
     *     description="Login portal menggunakan Google ID token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"idtoken","type"},
     *             @OA\Property(property="idtoken", type="string", example="ya29.a0AfH6SMB..."),
     *             @OA\Property(property="type", type="string", example="applicant"),
     *             @OA\Property(property="device_token", type="string", example="device_token_example")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login Successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Login Successful"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object"),
     *                 @OA\Property(property="token", type="string", example="token123")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Token expired or invalid.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="error", example="error"),
     *             @OA\Property(property="message", type="string", example="Token expired or invalid."),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Failed"),
     *             @OA\Property(property="errors", type="object"),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to verify Google token.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to verify Google token."),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */
    public function login_with_google(Request $request) {
        try {
            $validated = Validator::make(
                $request->all(),
                [
                    "type" => "required|string",
                    "device_token" => "sometimes|string",
                    "idtoken" => "required",
                ]
            );

            if ($validated->fails()) {
                return response()->json([
                    "status" => "error",
                    "message" => "Validation Failed",
                    "errors" => $validated->errors(),
                    "data" => null
                ], 422);
            } else {
                $idToken = $validated->getValue("idtoken");
                $auth = (new Factory)
                    ->withServiceAccount(storage_path('firebase_credentials.json'))
                    ->createAuth();
    
                try {
                    $verifiedIdToken = $auth->verifyIdToken($idToken);
                } catch (\Kreait\Firebase\Exception\Auth\FailedToVerifyToken $e) {
                    return response()->json([
                        "data" => null,
                        "status" => "error",
                        "message" => "Token expired or invalid."
                    ], 400);
                }
    
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
        } catch (\Throwable $e) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to verify Google token.",
                "data" => null
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     summary="Register",
     *     description="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password","password_confirmation","type"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
     *             @OA\Property(property="type", type="string", example="applicant")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Registration Successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Registration Successful"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object"),
     *                 @OA\Property(property="token", type="string", example="token123")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Failed"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Registration Failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Registration Failed")
     *         )
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                "email" => "required|email|unique:users,email",
                "password" => "required|confirmed|string|min:8",
                "type" => "required|in:admin,recruiter,applicant",
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
                "type" => $validated->getValue("type"),
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
    public function user()
    {
        return response()->json([
            "status" => "success",
            "data" => Auth::guard('sanctum')->user()
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Auth"},
     *     summary="Logout",
     *     description="Logout the authenticated user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout Successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Logout Successful")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        Auth::guard('sanctum')->user()->currentAccessToken()->delete();
        return response()->json([
            "status" => "success",
            "message" => "Logout Successful"
        ], 200);
    }
}
