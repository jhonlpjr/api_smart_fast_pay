<?php

namespace app\shared\dtos\api\response;

use Illuminate\Http\Response;

class ResponseDto {

  public int $statusCode = 200;

  public string $message;

  public $data;

  public function __construct(array $dataRes) {
    $this->statusCode = $dataRes['statusCode'] ?? Response::HTTP_OK;
    $this->data = $dataRes['data'] ?? [];
    $this->message = $dataRes['message'] ?? 'OK';
  }
}