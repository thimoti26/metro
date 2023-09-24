<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Normalizer;

use App\Shared\Domain\Model\StringValueObject;


final class StringValueObjectNormalizer extends ValueObjectNormalizer
{
    /**
     * @param string|null $format
     * @return array<class-string|'*'|'object'|string, bool|null>
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null, // Doesn't supports any classes or interfaces
            '*' => null, // Supports any other types, but the result is not cacheable
            StringValueObject::class => true, // Supports ValueObject and result is cacheable
        ];
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array<string> $context
     * @return string
     */
    public function normalize(mixed $object, string $format = null, array $context = []): string
    {
        $attribute = $this->getAttributes($object, $format, $context)[0];
        return $this->getAttributeValue($object, $attribute, $format);
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array<string> $context
     * @return StringValueObject
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): StringValueObject
    {
        /** @var StringValueObject $type */
        return new $type($data);
    }
}
