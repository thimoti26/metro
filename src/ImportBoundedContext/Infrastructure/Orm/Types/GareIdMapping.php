<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\Orm\Types;

use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class GareIdMapping extends Type
{
    const NAME = 'gare_id_value_object';
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
    public function convertToPHPValue($value, AbstractPlatform $platform): GareIdValueObject
    {
        return new GareIdValueObject($value);
    }

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): int
    {
        /** @var GareIdValueObject $value */
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
