<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;

class AuthLoginController extends Controller
{
    public function redirectUser(): JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl()
        ]);
    }

    public function handleAuthCallback() : JsonResponse
    {
        try {
            $socialiteUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Invalid credintial provided.'
            ], 422);
        }

        $user = User::query()
                ->firstOrCreate([
                    'email' => $socialiteUser->getEmail(),
                ], [
                    'email_verified_at' => now(),
                    'username' => $socialiteUser->getNamme(), 
                    'email' => $socialiteUser,
                    'password' => bcrypt(12345678), 
                    'level_user' => 2, 
                    'googel_id' => $socialiteUser->getId()
                ]);
        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken('google-token')->plainTextToken,
            'token_type' => 'Bearer'
        ]);
    }
}
