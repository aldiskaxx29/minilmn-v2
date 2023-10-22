<?php

namespace App\Repositories;

use App\Models\User;
use App\Services\GameServices;

class UserRepository{

  private $gameServices;

  public function __construct(
    GameServices $gameServices
  )
  {
    $this->gameServices = $gameServices;
  }

  public function getAll(){
    return $this->gameServices->getAll();
  }

  public function getOne(){

  }

  public function save(){

  }

  public function delete(){

  }
}