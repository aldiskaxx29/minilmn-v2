<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function login(){
    }

    public function register($params){
        if (array_key_exists('id', $params) && $params['id'] != null) {
            $user = $this->user->where('id', $params['id'])->first();
            $user->name = $params['name'];
            $user->email = $params['email'];
            $user->password = $params['password'];
            $user->image = $params['image'];
            $user->parent = $params['parent'];
            $user->save();
        } else {
            $params['level_user'] = 1;
            $params['password'] = bcrypt($params['password']);
            $user = $this->user->create($params);
        }

        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }
}