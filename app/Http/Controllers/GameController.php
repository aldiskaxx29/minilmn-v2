<?php

namespace App\Http\Controllers;

use App\Services\GameServices;
use Illuminate\Http\Request;

class GameController extends Controller
{
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

    public function getOne(Request $request){
        return $this->gameServices->getOne($request);
    }

    public function save(Request $request){
        return $this->gameServices->save($request);
    }

    public function delete(Request $request){
        return $this->gameServices->delete($request);
    }
}
