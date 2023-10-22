<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginGoogleController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        $userGoogleId = Socialite::driver('google')->user();

        // Ambil user dari database berdasarkan google user id
        $userGoogle = User::where('google_id', $userGoogleId->getId())->first();

        if (!$userGoogle) {
            $params['google_id'] = $userGoogle->getId;
            $params['email'] = $userGoogle->getEmail;
            $params['name'] = $userGoogle->getName;
            $params['image'] = 'path';
            
            $user = User::create($params);

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'belum ada'
            ]);
        } else{
            return response()->json([
                'status' => true,
                'user' => $userGoogle,
                'message' => 'sudah ada'
            ]);
        }
    }
}
