<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Normalizer;

use Closure;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use stdClass;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Serializer\Mapping\AttributeMetadata;
use Symfony\Component\Serializer\Mapping\AttributeMetadataInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use function array_key_exists;
use function is_object;


abstract class ValueObjectNormalizer extends AbstractObjectNormalizer
{
    protected PropertyAccessorInterface $propertyAccessor;

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
        $this->objectClassResolver = (static fn($class) => is_object($class) ? $class::class : $class)(...);
        parent::__construct();
    }

    /**
     * @param string|null $format
     * @return array<string, bool|null>
     */
    abstract public function getSupportedTypes(?string $format): array;

    /**
     * @param object $object
     * @param string|null $format
     * @param array<string> $context
     *
     * @return array<string>
     * @throws ReflectionException
     */
    protected function extractAttributes(object $object, string $format = null, array $context = []): array
    {
        if (stdClass::class === $object::class) {
            return array_keys((array)$object);
        }

        // If not using groups, detect manually
        $attributes = [];

        // methods
        $class = ($this->objectClassResolver)($object);
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

            if (null !== $attributeName && $this->isAllowedAttribute($object, $attributeName, $format, $context)) {
                $attributes[$attributeName] = true;
            }
        }

        // properties
        foreach ($reflClass->getProperties() as $reflProperty) {
            if (!$reflProperty->isPublic()) {
                continue;
            }

            if ($reflProperty->isStatic() || !$this->isAllowedAttribute($object, $reflProperty->name, $format, $context)) {
                continue;
            }

            $attributes[$reflProperty->name] = true;
        }

        return array_keys($attributes);
    }

    /**
     * @param object $object
     * @param string $attribute
     * @param string|null $format
     * @param array<string> $context
     * @return mixed
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
     * @param object $object
     * @param string $attribute
     * @param mixed $value
     * @param string|null $format
     * @param array<string> $context
     * @return void
     */
    protected function setAttributeValue(object $object, string $attribute, mixed $value, string $format = null, array $context = []): void
    {
        try {
            $this->propertyAccessor->setValue($object, $attribute, $value);
        } catch (NoSuchPropertyException) {
            // Properties not found are ignored
        }
    }

    /**
     * @param string|object $classOrObject
     * @param array<string> $context
     * @param bool $attributesAsString
     * @return array<string>|bool|AttributeMetadataInterface[]
     */
    protected function getAllowedAttributes(string|object $classOrObject, array $context, bool $attributesAsString = false): array|bool
    {
        if (false === $allowedAttributes = parent::getAllowedAttributes($classOrObject, $context, $attributesAsString)) {
            return false;
        }

        if (null !== $this->classDiscriminatorResolver) {
            $class = is_object($classOrObject) ? $classOrObject::class : $classOrObject;
            if (null !== $discriminatorMapping = $this->classDiscriminatorResolver->getMappingForMappedObject($classOrObject)) {
                $allowedAttributes[] = $attributesAsString ? $discriminatorMapping->getTypeProperty() : new AttributeMetadata($discriminatorMapping->getTypeProperty());
            }

            if (null !== $discriminatorMapping = $this->classDiscriminatorResolver->getMappingForClass($class)) {
                $attributes = [];
                foreach ($discriminatorMapping->getTypesMapping() as $mappedClass) {
                    $attributes[] = parent::getAllowedAttributes($mappedClass, $context, $attributesAsString);
                }
                $allowedAttributes = array_merge($allowedAttributes, ...$attributes);
            }
        }

        return $allowedAttributes;
    }
}
