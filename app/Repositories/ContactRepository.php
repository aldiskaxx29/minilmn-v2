<?php

namespace App\Repositories;

use App\Models\ContactUs;

class ContactRepository{

  private $model;

  public function __construct(
    ContactUs $model
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
    return $this->model->create($params);
  }

  public function delete($id){
    return $this->model->where('id', $id)->delete();
  }
}