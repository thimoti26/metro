<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Normalizer;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use function is_string;

class DateTimeNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /** @var string */
    public const FORMAT_KEY = 'datetime_format';

    /** @var string */
    public const TIMEZONE_KEY = 'datetime_timezone';
    /** @var array<bool> */
    private const SUPPORTED_TYPES = [
        DateTimeInterface::class => true,
        DateTimeImmutable::class => true,
        DateTime::class => true,
    ];

    /**
     * @var array<?string>
     */
    private array $defaultContext = array(
        self::FORMAT_KEY => DateTimeInterface::RFC3339,
        self::TIMEZONE_KEY => null,
    );

    /**
     * @param array<string> $defaultContext
     */
    public function __construct(array $defaultContext = [])
    {
        $this->setDefaultContext($defaultContext);
    }

    /**
     * @param array<string> $defaultContext
     * @return void
     */
    public function setDefaultContext(array $defaultContext): void
    {
        $this->defaultContext = array_merge($this->defaultContext, $defaultContext);
    }

    /**
     * @param string|null $format
     * @return array<bool>
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => __CLASS__ === DateTimeNormalizer::class
        ];
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array<string> $context
     * @return string
     * @throws Exception
     */
    public function normalize(mixed $object, string $format = null, array $context = []): string
    {
        if (!$object instanceof DateTimeInterface) {
            throw new InvalidArgumentException('The object must implement the "\DateTimeInterface".');
        }

        $dateTimeFormat = $context[self::FORMAT_KEY] ?? $this->defaultContext[self::FORMAT_KEY];
        $timezone = $this->getTimezone($context);

        if (null !== $timezone) {
            $object = clone $object;
            if ($object instanceof DateTimeImmutable) {
                $object = $object->setTimezone($timezone);
            }
        }

        return $object->format($dateTimeFormat);
    }

    /**
     * @param array<string> $context
     * @return DateTimeZone|null
     * @throws Exception
     */
    private function getTimezone(array $context): ?DateTimeZone
    {
        $dateTimeZone = $context[self::TIMEZONE_KEY] ?? $this->defaultContext[self::TIMEZONE_KEY];

        if (null === $dateTimeZone) {
            return null;
        }

        return new DateTimeZone($dateTimeZone);
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @param array<string> $context
     * @return bool
     */
    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof DateTimeInterface;
    }

    /**
     * @param $data
     * @param string $type
     * @param string|null $format
     * @param array<string> $context
     * @return DateTimeInterface
     * @throws Exception
     */
    public function denormalize($data, string $type, string $format = null, array $context = []): DateTimeInterface
    {
        $dateTimeFormat = $context[self::FORMAT_KEY] ?? null;
        $timezone = $this->getTimezone($context);

        if (null === $data || (is_string($data) && '' === trim($data))) {
            throw NotNormalizableValueException::createForUnexpectedDataType('The data is either an empty string or null, you should pass a string that can be parsed with the passed format or a valid DateTime string.', $data, [Type::BUILTIN_TYPE_STRING], $context['deserialization_path'] ?? null, true);
        }

        if (null !== $dateTimeFormat) {
            $object = DateTime::class === $type ? DateTime::createFromFormat($dateTimeFormat, $data, $timezone) : DateTimeImmutable::createFromFormat($dateTimeFormat, $data, $timezone);

            if (false !== $object) {
                return $object;
            }

            $dateTimeErrors = DateTime::class === $type ? DateTime::getLastErrors() : DateTimeImmutable::getLastErrors();

            throw NotNormalizableValueException::createForUnexpectedDataType(sprintf('Parsing datetime string "%s" using format "%s" resulted in %d errors: ', $data, $dateTimeFormat, $dateTimeErrors['error_count']) . "\n" . implode("\n", $this->formatDateTimeErrors($dateTimeErrors['errors'])), $data, [Type::BUILTIN_TYPE_STRING], $context['deserialization_path'] ?? null, true);
        }

        $defaultDateTimeFormat = $this->defaultContext[self::FORMAT_KEY] ?? null;

        if (null !== $defaultDateTimeFormat) {
            if (is_array($data)) {
                $timezone = new DateTimeZone($data['timezone']);
                $object = DateTime::class === $type ? DateTime::createFromFormat($defaultDateTimeFormat, $data['date'], $timezone) : DateTimeImmutable::createFromFormat($defaultDateTimeFormat, $data['date'], $timezone);
            } else {
                $object = DateTime::class === $type ? DateTime::createFromFormat($defaultDateTimeFormat, $data, $timezone) : DateTimeImmutable::createFromFormat($defaultDateTimeFormat, $data, $timezone);
            }

            if (false !== $object) {
                return $object;
            }
        }

        try {
            if (is_array($data)) {
                $timezone = new DateTimeZone($data['timezone']);
                return DateTime::class === $type ? new DateTime($data['date'], $timezone) : new DateTimeImmutable($data['date'], $timezone);
            } else {
                return DateTime::class === $type ? new DateTime($data, $timezone) : new DateTimeImmutable($data, $timezone);
            }
        } catch (Exception $e) {
            throw NotNormalizableValueException::createForUnexpectedDataType($e->getMessage(), $data, [Type::BUILTIN_TYPE_STRING], $context['deserialization_path'] ?? null, false, $e->getCode(), $e);
        }
    }

    /**
     * @param array<string> $errors
     * @return array<string>
     */
    private function formatDateTimeErrors(array $errors): array
    {
        $formattedErrors = [];

        foreach ($errors as $pos => $message) {
            $formattedErrors[] = sprintf('at position %d: %s', $pos, $message);
        }

        return $formattedErrors;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array<string> $context
     * @return bool
     */
    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return isset(self::SUPPORTED_TYPES[$type]);
    }
}

