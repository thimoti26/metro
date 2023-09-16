<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Orm\Types;

use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionIdValueObject;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ConnexionIdMapping extends Type
{
    /**
     * @param array $column
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ConnexionIdValueObject
    {
        return new ConnexionIdValueObject($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): int
    {
        /** @var ConnexionIdValueObject $value */
        return $value->getValue();
    }

    public function getName()
    {
        return ParameterType::INTEGER;
        // TODO: Implement getName() method.
    }
}
