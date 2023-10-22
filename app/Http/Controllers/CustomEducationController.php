<?php

namespace App\Http\Controllers;

use App\Services\CustomEducationServices;
use Illuminate\Http\Request;

class CustomEducationController extends Controller
{
    private $customEducation;

    public function __construct(
        CustomEducationServices $customEducation
    )
    {
        $this->customEducation = $customEducation;
    }

    public function getAll(){
        return $this->customEducation->getAll();
    }

    public function getOne(Request $request){
        return $this->customEducation->getOne($request);
    }

    public function save(Request $request){
        return $this->customEducation->save($request);
    }

    public function delete(Request $request){
        return $this->customEducation->delete($request);
    }
}
