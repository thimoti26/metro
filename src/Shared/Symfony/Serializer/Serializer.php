<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Serializer;
use App\Shared\Symfony\Encoder\EntityCollectionEncoder;
use App\Shared\Symfony\Encoder\EntityEncoder;
use App\Shared\Symfony\Normalizer\ArrayObjectNormalizer;
use App\Shared\Symfony\Normalizer\DateTimeNormalizer;
use App\Shared\Symfony\Normalizer\ValueObjectNormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as BaseSerializer;

class Serializer extends BaseSerializer
{

    public function __construct()
    {
        $entityEncoder = new EntityEncoder();
        // Serialization tools to handle body request with nested objects as payloads
        $encoders = [
            new JsonEncoder(),
            new CsvEncoder(),
            new EntityCollectionEncoder($entityEncoder),
            $entityEncoder
        ];
        $normalizers = [
            new ArrayObjectNormalizer(),
            new ValueObjectNormalizer(),
            new DateTimeNormalizer(),
            new ObjectNormalizer(null, null, null, new ReflectionExtractor()),
        ];
        parent::__construct($normalizers, $encoders);
    }
}
