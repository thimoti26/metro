<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Normalizer;

use App\Shared\Domain\Model\IntValueObject;


final class IntValueObjectNormalizer extends ValueObjectNormalizer
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
            IntValueObject::class => true, // Supports ValueObject and result is cacheable
        ];
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array<string> $context
     * @return int
     */
    public function normalize(mixed $object, string $format = null, array $context = []): int
    {
        $attribute = $this->getAttributes($object, $format, $context)[0];
        return $this->getAttributeValue($object, $attribute, $format);
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array<string> $context
     * @return IntValueObject
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): IntValueObject
    {
        /** @var IntValueObject $data */
        return new $type($data);
    }
}
