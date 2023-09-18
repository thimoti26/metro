<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Normalizer;

use App\Shared\Domain\Model\IntValueObject;


final class IntValueObjectNormalizer extends ValueObjectNormalizer
{

    /**
     * {@inheritdoc}
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null, // Doesn't supports any classes or interfaces
            '*' => null, // Supports any other types, but the result is not cacheable
            IntValueObject::class => true, // Supports ValueObject and result is cacheable
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(mixed $object, string $format = null, array $context = []): int
    {
        $attribute = $this->getAttributes($object, $format, $context)[0];
        return $this->getAttributeValue($object, $attribute, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): IntValueObject
    {
        /** @var IntValueObject $element */
        return new $type($data);
    }
}
