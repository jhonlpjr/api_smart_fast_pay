<?php

namespace app\shared\dtos\api\response;

use Illuminate\Http\Response;

class CreateResponseDto extends ResponseDto {
  public function __construct(array $dataRes) {
    parent::__construct($dataRes);
    $this->statusCode = Response::HTTP_CREATED;
  }
}