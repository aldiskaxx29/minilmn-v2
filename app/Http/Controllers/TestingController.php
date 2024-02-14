<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function index(){
        $arr = [
            "id" => 1,
            "nama" => "aldi skax"
        ];

        event(new TestEvent($arr));
        
        return view('testing');
    }
}
