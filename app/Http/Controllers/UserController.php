<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $authenticated = Auth::attempt($request->only([
            'email', 'password'
        ]));
        if ($authenticated) {
            /**
             * @var User $user
             */
            $user = Auth::user();
            $token = $user->createToken('user');
            return response()->json([
                'token' => $token->plainTextToken
            ]);
        }
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }

    public function logout()
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout'
        ]);
    }

    public function showAuthenticated(Request $request)
    {
        return new JsonResource($request->user());
    }
}
