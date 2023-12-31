<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Serializer;

use App\Shared\Exception\InvalidConstructorArgumentsParameterException;
use App\Shared\Symfony\Normalizer\ApiResponseNormalizer;
use App\Shared\Symfony\Normalizer\ArrayObjectNormalizer;
use App\Shared\Symfony\Normalizer\DateTimeNormalizer;
use App\Shared\Symfony\Normalizer\IntValueObjectNormalizer;
use App\Shared\Symfony\Normalizer\StringValueObjectNormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface as BaseSerializer;

/**
 * @inheritDoc
 */
class Serializer
{

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        // Serialization tools to handle body request with nested objects as payloads
        $encoders = [
            new JsonEncoder(),
            new CsvEncoder(),
        ];
        $normalizers = [
            new ApiResponseNormalizer(),
            new ArrayObjectNormalizer(),
            new StringValueObjectNormalizer(),
            new IntValueObjectNormalizer(),
            new DateTimeNormalizer(),
            new ObjectNormalizer(null, null, null, new ReflectionExtractor()),
        ];
//        parent::__construct($normalizers, $encoders);
    }

    public function serialize(mixed $data, string $format, array $context = []): string
    {
        // TODO: Implement serialize() method.
    }

    public function deserialize(mixed $data, string $type, string $format, array $context = []): mixed
    {
        // TODO: Implement deserialize() method.
    }
}
