<?php

namespace app\shared\dtos\api\response;

use Illuminate\Http\Response;

class ErrorResponseDto extends ResponseDto {
  public function __constructor(ResponseDto $dataRes) {
    parent::__construct($dataRes);
    $this->statusCode = $dataRes->statusCode || Response::HTTP_INTERNAL_SERVER_ERROR;
  }
}