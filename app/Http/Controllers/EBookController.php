<?php

namespace App\Http\Controllers;

use App\Services\EBookServices;
use Illuminate\Http\Request;

class EBookController extends Controller
{
    private $ebookServices;

    public function __construct(EBookServices $ebookServices)
    {
        $this->ebookServices = $ebookServices;
    }

    public function getAll(Request $request){
        return $this->ebookServices->getAll($request);
    }

    public function getOne(Request $request){
        return $this->ebookServices->getOne($request);
    }

    public function save(Request $request){
        return $this->ebookServices->save($request);
    }

    public function delete(Request $request){
        return $this->ebookServices->delete($request);
    }
}
