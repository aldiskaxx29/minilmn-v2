<?php

namespace App\Repositories;

use App\Models\Game;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GameRepository{

  protected $model;
  public function __construct(
    Game $model
  )
  {
    $this->model = $model;    
  }

  public function getAll(){
    return $this->model->get();
  }

  public function getOne($id){
    return $this->model->where('id', $id)->first();
  }

  public function save($params){
    if(array_key_exists('id', $params) && $params['id'] != null){
      $game = $this->model->where('id', $params['id'])->first();
      if($game->image && $params['image']){
        Storage::delete('public/' . $game->image);
      }
      $game->name = $params['name'] ?? '';
      $game->description = $params['description'] ?? '';
      $game->image = $params['image'];
      $game->save();
    } else{
      $game = $this->model->create($params);
    }

    return $game;
  }

  public function delete($id){

    $data = $this->model->where('id', $id)->first();
    if($data->image){
      Storage::delete('public/' . $data->image);
    }
    $data->delete();
    return $data;
  }
}