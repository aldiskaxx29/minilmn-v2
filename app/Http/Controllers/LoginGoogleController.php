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
        $userGoogleId = Socialite::driver('google')->stateless()->user();
        // Ambil user dari database berdasarkan google user id
        $userGoogle = User::where('google_id', $userGoogleId->getId())->first();

        if (!$userGoogle) {
            $params['google_id'] = $userGoogleId->id;
            $params['email'] = $userGoogleId->email;
            $params['name'] = $userGoogleId->name;
            $params['image'] = 'path';
            $params['password'] = bcrypt('12345678');
            
            $user = User::create($params);

            return response()->json([
                'status' => true,
                'user' => $user,
                'token' => $user->createToken('token')->plainTextToken,
            ]);
        } else{
            return response()->json([
                'status' => true,
                'access_token' => $userGoogle->createToken('token')->plainTextToken,
                'user' => $userGoogle,
            ]);
        }
    }
}
