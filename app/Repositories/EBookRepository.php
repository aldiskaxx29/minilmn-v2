<?php

namespace App\Repositories;

use App\Models\EBook;

class EBookRepository{

  private $model;

  public function __construct(EBook $model)
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
    if (array_key_exists('id', $params) && $params['id'] != null) {
      $ebook = $this->model->where('id', $params['id'])->update($params);
      return $ebook;
    } else {
      return $this->model->insert($params);
    }
    
  }

  public function delete($id){
    return $this->model->where('id', $id)->delete();
  }
}