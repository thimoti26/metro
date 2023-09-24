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
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use function array_key_exists;
use function is_object;

/**
 * @template T
 */
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
        $this->objectClassResolver = (static fn($class) => is_object($class) ? $class::class : $class)(...);
        parent::__construct();
    }

    /**
     * @return array<class-string|'*'|'object'|string, bool|null>
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
     * @param mixed $data Data to restore
     * @param string $type The expected class to instantiate
     * @param string|null $format Format the given data was extracted from
     * @param array<string> $context Options available to the denormalizer
     *
     * @return ArrayObject<T>
     *
     * @throws BadMethodCallException   Occurs when the normalizer is not called in an expected context
     * @throws InvalidArgumentException Occurs when the arguments are not coherent or not supported
     * @throws UnexpectedValueException Occurs when the item cannot be hydrated with the given data
     * @throws ExtraAttributesException Occurs when the item doesn't have attribute to receive given data
     * @throws LogicException           Occurs when the normalizer is not supposed to denormalize
     * @throws RuntimeException         Occurs if the class cannot be instantiated
     * @throws ExceptionInterface       Occurs for all the other cases of errors
     * @throws InvalidCollectionParameterException
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): ArrayObject
    {
        /** @var ArrayObject<T> $list */
        $list = new $type;
        foreach ($data as $element) {
            $response = parent::denormalize($element, $list->getCollectionClassType(), $format, $context);
            $list->append($response);
        }
        return $list;
    }

    /**
     * @param object $object
     * @param string|null $format
     * @param array<string> $context
     *
     * @return array<int<0, max>, array<int, string>>
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
}
