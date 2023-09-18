<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Normalizer;

use App\Shared\Domain\Model\ArrayObject;
use App\Shared\Exception\InvalidCollectionParameterException;
use Closure;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use function array_key_exists;
use function is_object;

class ArrayObjectNormalizer extends AbstractObjectNormalizer
{
    protected PropertyAccessor $propertyAccessor;

    /** @var array<string, string|null> */
    private array $discriminatorCache = [];

    /** @var Closure */
    private readonly Closure $objectClassResolver;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->objectClassResolver = ($objectClassResolver ?? static fn($class) => is_object($class) ? $class::class : $class)(...);
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null, // Doesn't supports any classes or interfaces
            '*' => null, // Supports any other types, but the result is not cacheable
            ArrayObject::class => true, // Supports ArrayObject and result is cacheable
        ];
    }

    /**
     * {@inheritdoc}
     * @throws InvalidCollectionParameterException
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): ArrayObject
    {
        /** @var ArrayObject $list */
        $list = new $type;
        foreach ($data as $element) {
            $response = parent::denormalize($element, $list->getCollectionClassType(), $format, $context);
            $list->append($response);
        }
        return $list;
    }

    /**
     * {@inheritdoc}
     * @throws ReflectionException
     */
    protected function extractAttributes(object $object, string $format = null, array $context = []): array
    {
        $elements = [];
        foreach ($object as $data) {

            // If not using groups, detect manually
            $attributes = [];

            // methods
            $class = ($this->objectClassResolver)($data);
            $reflClass = new ReflectionClass($class);

            foreach ($reflClass->getMethods(ReflectionMethod::IS_PUBLIC) as $reflMethod) {
                if (
                    0 !== $reflMethod->getNumberOfRequiredParameters()
                    || $reflMethod->isStatic()
                    || $reflMethod->isConstructor()
                    || $reflMethod->isDestructor()
                ) {
                    continue;
                }

                $name = $reflMethod->name;
                $attributeName = null;

                if (str_starts_with($name, 'get') || str_starts_with($name, 'has') || str_starts_with($name, 'can')) {
                    // getters, hassers and canners
                    $attributeName = substr($name, 3);

                    if (!$reflClass->hasProperty($attributeName)) {
                        $attributeName = lcfirst($attributeName);
                    }
                } elseif (str_starts_with($name, 'is')) {
                    // issers
                    $attributeName = substr($name, 2);

                    if (!$reflClass->hasProperty($attributeName)) {
                        $attributeName = lcfirst($attributeName);
                    }
                }

                if (null !== $attributeName && $this->isAllowedAttribute($data, $attributeName, $format, $context)) {
                    $attributes[$attributeName] = true;
                }
            }

            // properties
            foreach ($reflClass->getProperties() as $reflProperty) {
                if (!$reflProperty->isPublic()) {
                    continue;
                }

                if ($reflProperty->isStatic() || !$this->isAllowedAttribute($data, $reflProperty->name, $format, $context)) {
                    continue;
                }

                $attributes[$reflProperty->name] = true;
            }

            $elements[] = array_keys($attributes);
        }
        return $elements;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAttributeValue(object $object, string $attribute, string $format = null, array $context = []): mixed
    {
        $cacheKey = $object::class;
        if (!array_key_exists($cacheKey, $this->discriminatorCache)) {
            $this->discriminatorCache[$cacheKey] = null;
            if (null !== $this->classDiscriminatorResolver) {
                $mapping = $this->classDiscriminatorResolver->getMappingForMappedObject($object);
                $this->discriminatorCache[$cacheKey] = $mapping?->getTypeProperty();
            }
        }

        return $attribute === $this->discriminatorCache[$cacheKey] ? $this->classDiscriminatorResolver->getTypeForMappedObject($object) : $this->propertyAccessor->getValue($object, $attribute);
    }

    /**
     * {@inheritdoc}
     */
    protected function setAttributeValue(object $object, string $attribute, mixed $value, string $format = null, array $context = []): void
    {
        try {
            $this->propertyAccessor->setValue($object, $attribute, $value);
        } catch (NoSuchPropertyException) {
            // Properties not found are ignored
        }
    }
}
