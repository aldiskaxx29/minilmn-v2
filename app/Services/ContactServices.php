<?php

namespace App\Services;

use App\Repositories\ContactRepository;
use Illuminate\Support\Facades\Validator;

class ContactServices{
  
  private $contactRepository;

  public function __construct(
    ContactRepository $contactRepository
  ){
    $this->contactRepository = $contactRepository;
  }

  public function getAll(){
    $data = $this->contactRepository->getAll();

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
  }

  public function getOne($request){
    $id = $request->id;
    $data = $this->contactRepository->getOne($id);
    return response()->json([
      'status' => true,
      'data' => $data
    ]);
  }

  public function save($request){
    $rules= [
      'name' => 'required',
      'message' => 'required'
  ];

  $messages= [
      'name.required' => 'Please enter a name.',
      'message.required' => 'Please enter a message.'
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
      'name',
      'message'
    ]);

    try {
      $data = $this->contactRepository->save($params);
      return response()->json([
        'status' => true,
        'data' => $data 
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function delete($request){
    $id = $request->id;
    try {
      $data = $this->contactRepository->delete($id);
      return response()->json([
        'sttaus' => true,
        'data' => $data
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }
  
}