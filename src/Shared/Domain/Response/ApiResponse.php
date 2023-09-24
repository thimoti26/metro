<?php

declare(strict_types=1);

namespace App\Shared\Domain\Response;

use App\Shared\Domain\Model\ArrayObject;
use App\Shared\Domain\Model\DateTimeValueObject;
use App\Shared\Domain\Model\ValueObject;
use App\Shared\Domain\Model\Entity;

/**
 * @template T
 */
class ApiResponse
{
    /** @var int */
    private int $code;
    /** @var string */
    private string $message;
    /** @var ArrayObject<T>|DateTimeValueObject|Entity<T>|ValueObject */
    private ArrayObject|DateTimeValueObject|Entity|ValueObject $content;
    /** @var int */
    private int $httpStatusCode;
    /** @var array<string> */
    private array $headers;

    /**
     * @param int $code
     * @param string $message
     * @param ArrayObject<T>|DateTimeValueObject<T>|ValueObject|Entity<T> $content
     * @param int $httpStatusCode
     * @param array<string> $headers
     */
    public function __construct(int $code, string $message, DateTimeValueObject|Entity|ValueObject|ArrayObject $content, int $httpStatusCode = 200, array $headers = [])
    {
        $this->code = $code;
        $this->message = $message;
        $this->content = $content;
        $this->httpStatusCode = $httpStatusCode;
        $this->headers = $headers;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return ArrayObject<T>|DateTimeValueObject|Entity<T>|ValueObject
     */
    public function getContent(): DateTimeValueObject|Entity|ValueObject|ArrayObject
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
