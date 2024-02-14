<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\ForgotPassword as ModelsForgotPassword;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuthServices;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    private $authServices;
    private $request;

    public function __construct(
            Request $request,
            AuthServices $authServices
        ){
        $this->request = $request;
        $this->authServices = $authServices;
    }

    public function login(){
        return $this->authServices->login($this->request);
    }

    public function register(){
        return $this->authServices->register($this->request);
    }

    public function forgotPassword(Request $request){
        $email = $request->email;
        
        $user = User::where('email', $email)->first();
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'Email not found'
            ]);
        }
        $date = date('Y-m-d H:i:s');
        $time = date('Y-m-d H:i:s', strtotime($date.' +1 hour'));
        $code = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $message = [
            'code' => $code,
            'expired' => $time
        ];
        Mail::to($user->email)->send(new ForgotPassword($message));
        if($user){
            ModelsForgotPassword::create([
                'user_id' => $user->id,
                'code' => $code,
                'expired' => $time
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Email berhasil di kirim'
        ]);
    }

    public function checkCode(Request $request){
        $code = $request->code;
        $check = ModelsForgotPassword::where('code', $code)->first();

        $dateNow = date('Y-m-d H:i:s');
        if(!$check){
            return response()->json([
                'status' => false,
                'message' => 'Code yang anda masukan salah'
            ]);
        }
        if($check->expired < $dateNow){
            return response()->json([
                'status' => false,
                'message' => 'Code expired'
            ]);
        }
        
        $check->status = 1;
        $check->save();

        return response()->json([
            'status' => true,
            'data' => $check
        ]);

    }

    public function updatePassword(){
        return $this->authServices->updatePassword();
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User berhasil logout'
        ]);
    }
}
