<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Transport;

class MqttMessage
{
    /** @var string */
    private string $topic;
    /** @var string */
    private string $message;
    /** @var bool */
    private bool $retained;

    /**
     * @param string $topic
     * @param string $message
     * @param bool $retained
     */
    public function __construct(string $topic, string $message, bool $retained)
    {
        $this->topic = $topic;
        $this->message = $message;
        $this->retained = $retained;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function isRetained(): bool
    {
        return $this->retained;
    }
}
