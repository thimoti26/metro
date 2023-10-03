<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Orm\Types;

use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionIdValueObject;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ConnexionIdMapping extends Type
{
    const NAME = 'connexion_id_value_object';
    /**
     * @inheritDoc
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    /**
     * @inheritDoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ConnexionIdValueObject
    {
        return new ConnexionIdValueObject($value);
    }

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): int
    {
        /** @var ConnexionIdValueObject $value */
        return $value->getValue();
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
