<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Orm\Types;

use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class GareIdMapping extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): GareIdValueObject
    {
        return new GareIdValueObject($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): int
    {
        /** @var GareIdValueObject $value */
        return $value->getValue();
    }

    public function getName()
    {
        return ParameterType::INTEGER;
        // TODO: Implement getName() method.
    }
}
