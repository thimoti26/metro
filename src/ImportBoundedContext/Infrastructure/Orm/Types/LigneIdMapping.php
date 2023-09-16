<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Orm\Types;

use App\ImportBoundedContext\Domain\Model\Ligne\LigneIdValueObject;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class LigneIdMapping extends Type
{

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): LigneIdValueObject
    {
        return new LigneIdValueObject($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        /** @var LigneIdValueObject $value */
        return $value->getValue();
    }

    public function getName()
    {
        return ParameterType::INTEGER;
        // TODO: Implement getName() method.
    }
}
