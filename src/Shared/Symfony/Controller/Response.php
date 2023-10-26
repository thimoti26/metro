<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Controller;

use App\Shared\Domain\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Response as BaseResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @template T
 */
class Response extends BaseResponse
{

    /**
     * @param ApiResponse<T> $apiResponse
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ApiResponse $apiResponse,
        private readonly SerializerInterface $serializer
    )
    {
        if (false === array_key_exists('Content-Type', $apiResponse->getHeaders())) {
            $headers = $apiResponse->getHeaders();
            $headers['Content-Type'] = 'application/json; charset=UTF-8';
            $apiResponse = new ApiResponse(
                $apiResponse->getCode(),
                $apiResponse->getMessage(),
                $apiResponse->getContent(),
                $apiResponse->getHttpStatusCode(),
                $headers
            );
        }
        parent::__construct($this->serializer->serialize($apiResponse, 'json'), $apiResponse->getHttpStatusCode(), $apiResponse->getHeaders());
    }
}
