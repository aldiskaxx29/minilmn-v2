<?php

namespace App\Services;

use App\Repositories\CustomEducationRepository;
use Illuminate\Support\Facades\Validator;

class CustomEducationServices{

  private $customEducationRepository;
  public function __construct(
    CustomEducationRepository $customEducationRepository
  ){
    $this->customEducationRepository = $customEducationRepository;
  }

  public function getAll(){
    $data = $this->customEducationRepository->getAll();
    return response()->json([
      'status' => true,
      'data' => $data
    ]);
  }

  public function getOne($request){
    $id = $request->id;
    try {
      $data = $this->customEducationRepository->getOne($id);
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

  public function save($request){
    $rules= [
      'level' => 'required',
      'description' => 'required',
      'question' => 'required',
      'answer' => 'required'
  ];

  $messages= [
      'level.required' => 'Please enter a level.',
      'description.required' => 'Please enter a description.',
      'question.required' => 'Please enter a question.',
      'answer.required' => 'Please enter a answer.',
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
      'level',
      'description',
      'question',
      'answer',
    ]); 

    try {
      $data = $this->customEducationRepository->save($params);
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
      $data = $this->customEducationRepository->delete($id);

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
  
}