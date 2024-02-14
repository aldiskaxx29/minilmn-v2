<?php

namespace App\Http\Controllers;

use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

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

    public function getOne(){
        return $this->userServices->getOne();
    }

    public function save(Request $request){
        return $this->userServices->save($request);
    }

    public function delete(Request $request){
        return $this->userServices->delete($request);
    }


}
