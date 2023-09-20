<?php

declare(strict_types=1);

namespace App\Shared\Domain\Response;

use App\Shared\Domain\Model\ArrayObject;
use App\Shared\Domain\Model\DateTimeValueObject;
use App\Shared\Domain\Model\ValueObject;
use Doctrine\ORM\Mapping\Entity;

class ApiResponse
{
    private int $code;
    private string $message;
    private ArrayObject|DateTimeValueObject|Entity|ValueObject $content;
    private int $httpStatusCode;
    private array $headers;

    /**
     * @param int $code
     * @param string $message
     * @param ArrayObject|DateTimeValueObject|ValueObject|Entity $content
     * @param int $httpStatusCode
     * @param array $headers
     */
    public function __construct(int $code, string $message, DateTimeValueObject|Entity|ValueObject|ArrayObject $content, int $httpStatusCode = 200, array $headers = [])
    {
        $this->code = $code;
        $this->message = $message;
        $this->content = $content;
        $this->httpStatusCode = $httpStatusCode;
        $this->headers = $headers;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getContent(): DateTimeValueObject|Entity|ValueObject|ArrayObject
    {
        return $this->content;
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
