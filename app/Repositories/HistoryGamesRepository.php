<?php

namespace App\Repositories;

use App\Models\HistoryGame;

class HistoryGamesRepository{

  private $model;

  public function __construct(
    HistoryGame $model
  ){
    $this->model = $model;
  }

  public function getAll(){
    return $this->model->with(['game','user'])->get();
  }

  public function getOne($id){
    return $this->model->where('id', $id)->first();
  }

  public function save($params){
    if(array_key_exists('id', $params) && $params['id'] != null){
      $gameHistory = $this->model->where('id', $params['id'])->first();
      $gameHistory->game_id = $params['game_id'];
      $gameHistory->user_id = $params['user_id'];
      $gameHistory->date = $params['date'];
      $gameHistory->time = $params['time'];
      $gameHistory->save();
    } else{
      $gameHistory = $this->model->create($params);
    }

    return $gameHistory;
  }

  public function delete($id){
    return $this->model->where('id', $id)->delete();
  }

  public function daily($user, $now){
    return $this->model->where('user_id', $user)
          ->where('date', $now)->get();
  }

  public function weekly($start, $end, $user){
    return $this->model->where('user_id', $user)
    ->whereBetween('date', [$start, $end])->get();
  }

  public function monthly($month, $user){
    return $this->model->where('user_id', $user)
    ->whereMonth('date', $month)->get();
  }
}