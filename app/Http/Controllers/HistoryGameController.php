<?php

namespace App\Http\Controllers;

use App\Services\HistoryGameServices;
use Illuminate\Http\Request;

class HistoryGameController extends Controller
{
    private $historyGame;

    public function __construct(
        HistoryGameServices $historyGame
    )
    {
        $this->historyGame = $historyGame;
    }

    public function getAll(){
        return $this->historyGame->getAll();
    }

    public function getOne(Request $request){
        return $this->historyGame->getOne($request);
    }

    public function save(Request $request){
        return $this->historyGame->save($request);
    }

    public function delete(Request $request){
        return $this->historyGame->delete($request);
    }
}
