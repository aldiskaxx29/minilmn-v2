<?php

namespace App\Repositories;

use App\Models\User;
use App\Services\GameServices;
use Illuminate\Http\Request;

class UserRepository{

  private $gameServices;
  public $model;
  public $request;
  public function __construct(
    GameServices $gameServices,
    User $model,
    Request $request,
  )
  {
    $this->gameServices = $gameServices;
    $this->model = $model;
    $this->request = $request;
  }

  public function getAll(){
    return $this->model->getAll();
  }

  public function getOne($id){
    return $this->model->where('id', $id)->first();
  }

  public function save($params){
    if (array_key_exists('id', $params) && $params['id'] != null) {
      $user = $this->model->where('id', $params['id'])->update([
        'username' => $params['username'] ?? '', 
        'email' => $params['email'] ?? '',
        // 'password' => bcrypt($params['password']), 
        'level_user' => $params['level_user'] ?? 1,
        'image' => $params['image'] ?? '', 
        'parent' => $params['parent'] ?? 0, 
        'status' => 1,
        'age' => $params['age'] ?? 0,
        'gender' => $params['gender'] ?? 0, 
      ]);
      $user = $this->model->where('id', $params['id'])->first();
    } else {
      $user = $this->model->create($params);
    }

    return $user;
  }

  public function delete($id){
    return $this->model->where('id', $id)->delete();
  }


  
}