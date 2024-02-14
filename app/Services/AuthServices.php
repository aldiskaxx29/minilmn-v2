<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Validator;

class AuthServices{
    protected $authRepository;
    public $request;

    public function __construct(
        AuthRepository $authRepository,
        Request $request
    ){
        $this->authRepository = $authRepository;
        $this->request = $request;
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
            'email' => 'required',
            'password' => 'required',
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

        $params = $request->only([
            'id',
            'username',
            'email',
            'password',
            'name_kids',
            'age',
            'parent',
            'gender'
        ]);

        if($request->file('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $name = time() . '.' . $extension;
            $path = $request->file('image')->storeAs('profile', $name, 'public');
        }

        $params['image'] = $path ?? '';

        $user = $this->authRepository->register($params);

        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }

    public function updatePassword(){
        $rules = [
          'password' => 'required',
          'konfirmasi_password' => 'required'
        ];
        $messaeg  = [
          'password.required' => 'Password canot be null',
          'konfirmasi_password.required' => 'Konfirmasi Password canot be null',
        ];
    
        $validator = Validator::make($this->request->all(), $rules, $messaeg);
    
        if($validator->fails()){
          $messages = $validator->messages();
          $error = $messages->all();
    
          return response()->json([
            'status' => false,
            'message' => $error
          ]);
        }
    
        $params = $this->request->only([
          'id',
          'password',
          'konfirmasi_password'
        ]);
    
        try {
          $user = $this->authRepository->updatePassword($params);
    
          return response()->json([
            'status' => true,
            'data' => $user
          ]);
        } catch (\Exception $e) {
          return response()->json([
            'status' => false,
            'messae' => $e->getMessage()
          ]);
        }
      }
}