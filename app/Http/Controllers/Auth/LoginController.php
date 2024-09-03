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
     * Handle an incoming authentication request.
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
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        // Get the current access token
        $token = $request->user()->currentAccessToken();

        // Ensure we have a valid token object before attempting to delete
        if ($token) {
            // Delete the token
            $token->delete();
            return response()->json(['message' => 'Logged out successfully'], 200);
        }

        // If no valid token is found, return a 404 response
        return response()->json(['message' => 'No token found'], 404);
    }
}
