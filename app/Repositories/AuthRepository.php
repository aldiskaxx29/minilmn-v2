<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository{
    private $model;

    public function __construct(User $model){
        $this->model = $model;
    }

    public function login(){
    }

    public function register($params){
        if (array_key_exists('id', $params) && $params['id'] != null) {
            $user = $this->model->where('id', $params['id'])->first();
            $user->username = $params['username'] ?? '';
            $user->email = $params['email'];
            // $user->password = $params['password'];
            $user->image = $params['image'];
            $user->parent = $params['parent'] ?? 0;
            $user->name_kids = $params['name_kids'] ?? '';
            $user->age = $params['age'] ?? 0;
            $user->gender = $params['gender'] ?? '';
            $user->save();
        } else {
            $params['level_user'] = 1;
            $params['password'] = bcrypt($params['password']);
            $user = $this->model->create($params);
        }

        return $user;
    }

    public function updatePassword($params){
        $user =  $this->model->where('id', $params['id'])->first();
        $user->password = bcrypt($params['password']);
        $user->save();

        return $user;
      }
}