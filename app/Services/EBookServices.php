<?php

namespace App\Services;

use App\Repositories\EBookRepository;
use Illuminate\Http\Request;

class EBookServices{

  private $ebookRepository;
  public $request;
  public function __construct(
    EBookRepository $ebookRepository,
    Request $request
    ) 
  {
    $this->ebookRepository = $ebookRepository;
    $this->request = $request;
  }

  public function getAll(){
    try {
      $data = $this->ebookRepository->getAll();
      return response()->json([
        'status' => true,
        'data' => $data
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
    
  }

  public function getOne(){
    $id = $this->request->input('id');
    try {
      $data = $this->ebookRepository->getOne($id);

      return response()->json([
        'status' => true,
        'data' => $data
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function save($request){
    $params = $request->only([
      'id',
      'title',
      'sub_title',
      'description'
    ]);

    try {
      $data = $this->ebookRepository->save($params);

      return response()->json([
        'status' => true,
        'data' => $data
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
    
  }

  public function delete($request){
    $id = $request->input('id');
  try {
    $data = $this->ebookRepository->delete($id);

    return response()->json([
      'status' => true,
      'data' => $data
    ]);
  } catch (\Exception $e) {
    return response()->json([
      'status' => false,
      'message' => $e->getMessage()
    ]);
  }
  }
}