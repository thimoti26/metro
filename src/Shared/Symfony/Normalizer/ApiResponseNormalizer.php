<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Normalizer;

use App\Shared\Domain\Response\ApiResponse;
use BadMethodCallException;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use stdClass;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorResolverInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;
use UnexpectedValueException;

class ApiResponseNormalizer extends AbstractObjectNormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    /** @var SerializerInterface|null */
    protected $serializer;

    /** @var NormalizerInterface */
    protected NormalizerInterface $normalizer;

    /** @var PropertyAccessorInterface */
    protected PropertyAccessorInterface $propertyAccessor;

    /**
     * @param ClassMetadataFactoryInterface|null $classMetadataFactory
     * @param NameConverterInterface|null $nameConverter
     * @param PropertyAccessorInterface|null $propertyAccessor
     * @param PropertyTypeExtractorInterface|null $propertyTypeExtractor
     * @param ClassDiscriminatorResolverInterface|null $classDiscriminatorResolver
     * @param callable|null $objectClassResolver
     * @param array $defaultContext
     */
    public function __construct(ClassMetadataFactoryInterface $classMetadataFactory = null, NameConverterInterface $nameConverter = null, PropertyAccessorInterface $propertyAccessor = null, PropertyTypeExtractorInterface $propertyTypeExtractor = null, ClassDiscriminatorResolverInterface $classDiscriminatorResolver = null, callable $objectClassResolver = null, array $defaultContext = [])
    {
        if (!class_exists(PropertyAccess::class)) {
            throw new LogicException('The ApiResponseNormalizer class requires the "PropertyAccess" component. Install "symfony/property-access" to use it.');
        }

        parent::__construct($classMetadataFactory, $nameConverter, $propertyTypeExtractor, $classDiscriminatorResolver, $objectClassResolver, $defaultContext);

        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function setSerializer(SerializerInterface $serializer): void
    {
        if (!$serializer instanceof DenormalizerInterface) {
            throw new InvalidArgumentException('Expected a serializer that also implements DenormalizerInterface.');
        }

        $this->serializer = $serializer;
    }

    /**
     * @param string|null $format
     * @return array
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => true,             // Doesn't support any classes or interfaces
            '*' => null,                 // Supports any other types, but the result is not cacheable
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        $className = $this->extractClass($type);
        return is_subclass_of($className, ApiResponse::class);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        //Il faut que sa classe soit un enfant de l'Api Response
        if (false === is_object($data)) {
            return false;
        }
        return is_subclass_of($data::class, ApiResponse::class);
    }

    /**
     * @param string $class
     */
    protected function checkRequirements(string $class): void
    {
        if (false === $this->containsSubclass($class)) {
            throw new BadMethodCallException('Api Response must contain subClasse');
        }

        if (null === $this->serializer) {
            throw new BadMethodCallException('Please set a serializer before calling denormalize()!');
        }

        $baseClass = $this->extractClass($class);

        if (ApiResponse::class === $baseClass) {
            throw new InvalidArgumentException('Class should be children of ApiResponse');
        }
        $parents = class_parents($baseClass);

        if (false === isset($parents[ApiResponse::class])) {
            throw new BadMethodCallException('Class should be children of ApiResponse.');
        }
    }

    /**
     * @param $class
     * @return string
     */
    protected function extractClass($class): string
    {
        preg_match('/^[a-zA-Z0-9_\x7f-\xff\\\\]+/', $class, $match);
        return $match[0];
    }

    /**
     * @param $type
     * @return bool
     */
    protected function containsSubclass($type): bool
    {
        return (bool)preg_match('/^[a-zA-Z0-9_\x7f-\xff\\\\]+<[a-zA-Z0-9_\x7f-\xff\\\\,]+>$/', $type);
    }

    /**
     * @param $class
     * @return string
     */
    protected function extractSubclass($class): string
    {
        preg_match('/<[a-zA-Z0-9_\x7f-\xff\\\\,]+>/', $class, $match);
        return substr($match[0], 1, -1);
    }

    /**
     * {@inheritdoc}
     *
     * @throws UnexpectedValueException
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): ApiResponse
    {
        $this->checkRequirements($type);

        if (array_key_exists('content', $data)) {
            $data['content'] = $this->serializer->denormalize($data['content'], $this->extractSubclass($type), $format, $context);
        }

        return parent::denormalize($data, $this->extractClass($type), $format, $context);
    }

    /**
     * @throws ReflectionException
     */
    protected function extractAttributes(object $object, string $format = null, array $context = []) : array
    {
        if (stdClass::class === $object::class) {
            return array_keys((array) $object);
        }

        // If not using groups, detect manually
        $attributes = [];

        // methods
        $class = $this->extractClass($object::class);
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

    protected function getAttributeValue(object $object, string $attribute, string $format = null, array $context = [])
    {
        return $this->propertyAccessor->getValue($object, $attribute);
    }

    protected function setAttributeValue(object $object, string $attribute, mixed $value, string $format = null, array $context = []): void
    {
        try {
            $this->propertyAccessor->setValue($object, $attribute, $value);
        } catch (NoSuchPropertyException) {
            // Properties not found are ignored
        }
    }
}
