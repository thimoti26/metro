<?php

declare(strict_types=1);

namespace App\Tests\Units\Symfony\Fixtures;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class ObjectSerializerNormalizerDenormalizer implements SerializerInterface, NormalizerInterface, DenormalizerInterface
{
}
