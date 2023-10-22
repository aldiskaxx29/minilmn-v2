<?php

namespace App\Http\Controllers;

use App\Services\ContactServices;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $contactServices;

    public function __construct(
        ContactServices $contactServices
    )
    {
        $this->contactServices = $contactServices;
    }

    public function getAll(){
        return $this->contactServices->getAll();
    }

    public function getOne(Request $request){
        return $this->contactServices->getOne($request);
    }

    public function save(Request $request){
        return $this->contactServices->save($request);
    }

    public function delete(Request $request){
        return $this->contactServices->delete($request);
    }
}
