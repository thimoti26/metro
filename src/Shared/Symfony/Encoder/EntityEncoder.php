<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Encoder;

use App\Shared\Orm\Entity\EntityInterface;
use ReflectionClass;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

class EntityEncoder implements EncoderInterface
{

    public function encode(mixed $data, string $format, array $context = []): string
    {
        dump($data, $format);
        try {
            $reflexion = new ReflectionClass($format);
            dd($reflexion->getConstructor());
        } catch (\ReflectionException $e) {
        }
    }

    public function supportsEncoding(string $format): bool
    {
        try {
            $reflection = new ReflectionClass($format);
            //Entity must have entityInterface
            if (array_key_exists(EntityInterface::class, $reflection->getInterfaces())) {
                return true;
            }

        } catch (\ReflectionException $e) {
        }
        return false;
    }
}
