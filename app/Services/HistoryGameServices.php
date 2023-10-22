<?php

namespace App\Services;

use App\Repositories\HistoryGamesRepository;
use Illuminate\Support\Facades\Validator;

class HistoryGameServices{

  private $historyGameRepository;

  public function __construct(
    HistoryGamesRepository $historyGameRepository
  ){
    $this->historyGameRepository = $historyGameRepository;
  }

  public function getAll(){
    $data = $this->historyGameRepository->getAll();
    return response()->json([
      'status' => true,
      'data' => $data
    ]);
  }

  public function getOne($request){
    $id = $request->id;
    $data = $this->historyGameRepository->getOne($id);
    return response()->json([
      'status' => true,
      'data' => $data
    ]);
  }

  public function save($request){
    $rules= [
      'game_id' => 'required',
      'user_id' => 'required',
      'date' => 'required',
      'time' => 'required'
    ];

    $messages= [
        'game_id.required' => 'Please enter a game_id.',
        'user_id.required' => 'Please enter a user_id.',
        'date.required' => 'Please enter a date.',
        'time.required' => 'Please enter a time.'
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
      'game_id',
      'user_id',
      'date',
      'time',
      'status'
    ]);

    $data = $this->historyGameRepository->save($params);
    return response()->json([
      'status' => true,
      'data' => $data
    ]);
  }

  public function delete($request){
    $id = $request->id;
    $data = $this->historyGameRepository->delete($id);
    return response()->json([
      'status' => true,
      'data' => $data
    ]);
  }
  
}