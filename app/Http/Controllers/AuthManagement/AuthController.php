<?php

namespace App\Http\Controllers\AuthManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * Auth API Controller
 *
 * This controller provides simple API endpoints for login (token issuance)
 * and retrieving the authenticated user. It includes OpenAPI annotations
 * compatible with swagger-php / L5-Swagger.
 */
class AuthController extends Controller
{
    /**
     * Login and create token
     *
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login and receive API token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="password", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => __('auth.failed') ?: 'Invalid credentials'], 401);
        }

        // Create a new token for the user
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * Get authenticated user
     *
     * @OA\Get(
     *     path="/api/me",
     *     summary="Get authenticated user",
     *     security={{"sanctum": {}}},
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
