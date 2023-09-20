<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Controller;

use App\Shared\Domain\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Response as BaseResponse;
use Symfony\Component\Serializer\SerializerInterface;

class Response extends BaseResponse
{

    public function __construct(
        ApiResponse $apiResponse,
        private SerializerInterface $serializer
    )
    {
        $data = new \stdClass();
        $data->code = $apiResponse->getCode();
        $data->message = $apiResponse->getMessage();
        $data->content = $apiResponse->getContent();

        parent::__construct($this->serializer->serialize($data, 'json'), $apiResponse->getHttpStatusCode(), $apiResponse->getHeaders());
    }
}