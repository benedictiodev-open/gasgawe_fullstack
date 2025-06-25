<?php

namespace App\Traits;

trait ResponseTrait
{
  protected function successResponse($data, $message = 'Success', $code = 200)
  {
    if ($data instanceof \Illuminate\Http\Resources\Json\ResourceCollection) {
      return $data->additional([
        'status'    => 'success',
        'message'   => $message,
        'error'     => false
      ])->response()->setStatusCode($code);
    }
    return response()->json([
      'status' => 'success',
      'message' => $message,
      'data' => $data,
      'error' => false
    ], $code);
  }

  protected function errorResponse($message, $code = 500)
  {
    return response()->json([
      'status' => 'error',
      'message' => $message,
      'data' => null,
      'error' => true
    ], $code);
  }
}
