<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Validator;

class AuthServices{
    protected $authRepository;

    public function __construct(
        AuthRepository $authRepository
    ){
        $this->authRepository = $authRepository;
    }

    public function login($request){
        $rules= [
            'email' => 'required',
            'password' => 'required'
        ];

        $messages= [
            'email.required' => 'Please enter a email.',
            'password.required' => 'Please enter a password.'
        ];
        
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();

            return response()->json([
                'status' => false,
                'message' => $errors
            ]);
        }

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        try {
            if (auth()->attempt($data)) {
                $user = auth()->user();
                $token = $user->createToken('token-api')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'data' => $user,
                    'access_token' => $token
                ]);   
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Username / Password salah'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function register($request){
        $rules= [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];

        $messages= [
            'name.required' => 'Please enter a name.',
            'email.required' => 'Please enter a email.',
            'password.required' => 'Please enter a password.'
        ];
        
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();

            return response()->json([
                'status' => false,
                'message' => $errors
            ]);
        }

        $params = $request->only([
            'id',
            'name',
            'email',
            'password'
        ]);

        if($request->file('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $name = time() . '.' . $extension;
            $path = $request->file('image')->storeAs('profile', $name, 'public');
        }

        $params['image'] = $path ?? '';

        return $this->authRepository->register($params);
    }
}