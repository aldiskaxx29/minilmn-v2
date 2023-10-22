<?php

namespace App\Http\Controllers;

use App\Services\UserServices;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userServices;

    public function __construct(
        UserServices $userServices
    )
    {
        $this->userServices = $userServices;
    }

    public function getAll(){
        return $this->userServices->getAll();
    }

    public function getOne(Request $request){
        return $this->userServices->getOne($request);
    }

    public function save(Request $request){
        return $this->userServices->save($request);
    }

    public function delete(Request $request){
        return $this->userServices->delete($request);
    }
}
