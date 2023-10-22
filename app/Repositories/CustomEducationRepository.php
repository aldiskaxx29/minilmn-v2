<?php

namespace App\Repositories;

use App\Models\CustomEducation;

class CustomEducationRepository{

  private $model;

  public function __construct(
    CustomEducation $model
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
      $data = $this->model->where('id', $params['id'])->first();
      $data->level = $params['level'];
      $data->description = $params['description'];
      $data->question = $params['question'];
      $data->answer = $params['answer'];
      $data->save();
    } else{
      $data = $this->model->create($params);
    }

    return $data;
  }

  public function delete($id){
    return $this->model->where('id', $id)->delete();
  }
}