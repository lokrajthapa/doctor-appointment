<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }


    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Authenticate user and generate token",
     *     description="Login a user and return a token along with user details",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="lokraj@gmail.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="token_string"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=6),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="user@example.com"),
     *                 @OA\Property(property="user_type", type="string", example="patient")
     *             ),
     *             @OA\Property(property="status", type="object",
     *                 @OA\Property(property="message", type="string", example="Patient Login successfully"),
     *                 @OA\Property(property="type", type="string", example="success")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *             @OA\Property(property="type", type="string", example="error")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="The email field is required.")),
     *                 @OA\Property(property="password", type="array", @OA\Items(type="string", example="The password field is required."))
     *             )
     *         )
     *     )
     * )
     */

    public function store(LoginRequest $request): JsonResponse
    {

        $request->authenticate();
        $user=User::where('email',$request->email)->first();
        $data=[
          'token'=> $user->createToken("api-token".$user->email)->plainTextToken,
          'user'=>[
             'name'=>$user->name,
              'email'=> $user->email,
             ]

       ];

    return response()->json($data,201);
    }

     /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Logout user",
     *     description="Logout the authenticated user and delete the access token",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User logout successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function destroy(Request $request): JsonResponse
    {

        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);

    }
}
