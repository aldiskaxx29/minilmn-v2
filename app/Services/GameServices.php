<?php

namespace App\Services;

use App\Repositories\GameRepository;
use App\Models\Game;
use Illuminate\Support\Facades\Validator;

class GameServices{

  private $gameRepository;

  public function __construct(
    GameRepository $gameRepository
  ){
    $this->gameRepository = $gameRepository;
  }

  public function getAll(){
    $data = $this->gameRepository->getAll();
    return response()->json([
      'status' => true,
      'data' => $data
    ]);
  }

  public function getOne($request){
    $id = $request->id;
    try {
      $data = $this->gameRepository->getOne($id);

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
      'name' => 'required',
      'description' => 'required'
  ];

  $messages= [
      'name.required' => 'Please enter a name.',
      'description.required' => 'Please enter a description.',
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
      'description',  
      'status'
    ]);

    try {
      if($request->file('image')){
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $name = time() .'.'. $extension;
        $path = $request->file('image')->storeAs('game', $name, 'public');
      }
  
      $params['image'] = $path;
      
      $data = $this->gameRepository->save($params);
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
    $data = $this->gameRepository->delete($id);
    return response()->json([
      'status' => true,
      'data' => $data
    ]);
  }
  
}