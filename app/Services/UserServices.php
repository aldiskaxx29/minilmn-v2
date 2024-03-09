<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserServices{

  public $request;
  private $userRepository;

  public function __construct(Request $request, UserRepository $userRepository){
    $this->request = $request;
    $this->userRepository = $userRepository;
  }

  public function getAll(){
    try {
      $data = $this->userRepository->getAll();
      return response()->json([
        'status' => true,
        'data' => $data
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'error' => $e->getMessage()
      ]);
    }
  }

  public function getOne(){
    try {
      $id = $this->request->id;

      $user = $this->userRepository->getOne($id);

      return response()->json([
        'status' => true,
        'data' => $user
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'error' => $e->getMessage()
      ]);
    }
  }

  public function save(){
    $params = $this->request->only([
      'id',
      'username', 
      'email', 
      'password', 
      'level_user',
      'image' , 
      'parent', 
      'status',
      'age',
      'gender', 
    ]);

    if($this->request->file('image')){
      $file = $this->request->file('image');
      $name = time();
      $extension = $file->getClientOriginalExtension();
      $fileName = $name.'.'.$extension;
      $params['image'] = $fileName;
    }

    try {
      $data = $this->userRepository->save($params);

      return response()->json([
        'status' => true,
        'data' => $data,
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'messaeg' => $e->getMessage(),
      ]);
    }
  }

  public function delete(){
    $id = $this->request->id;
    try {
      $this->userRepository->delete($id);

      return response()->json([
        'status' => true,
        'message' => 'Success delete user'
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }

  }


  
}