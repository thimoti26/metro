<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Encoder;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

class EntityCollectionEncoder implements EncoderInterface
{
    public function __construct(private EntityEncoder $entityEncoder)
    {
    }

    public function encode(mixed $data, string $format, array $context = []): string
    {
        return ('EntityCollectionEncoder');
    }

    public function decode(string $data, string $format, array $context = []): mixed
    {
    }

    public function supportsEncoding(string $format): bool
    {
        if (str_ends_with($format, '[]')) {
            $format = substr($format, 0, -2);
            return $this->entityEncoder->supportsEncoding($format);
        }
        return false;
    }

    public function supportsDecoding(string $format): bool
    {
        return false;
    }
}
