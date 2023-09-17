<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use App\Shared\Exception\InvalidCollectionParameterException;
use ArrayObject as BaseArrayObject;
use Iterator;
use OpenApi\Annotations as OA;

abstract class ArrayObject extends BaseArrayObject
{
    /**
     * @var string
     */
    protected string $collectionClassType;

    /**
     * @return string
     */
    public function getCollectionClassType(): string
    {
        return $this->collectionClassType;
    }

    /**
     * @OA\Property(type="")
     * @return array
     */
    public function getArrayCopy(): array
    {
        return parent::getArrayCopy(); // TODO: Change the autogenerated stub
    }

    /**
     * @OA\Property(type="")
     * @return Iterator
     */
    public function getIterator(): Iterator
    {
        return parent::getIterator(); // TODO: Change the autogenerated stub
    }


    /**
     * Enforce collection type
     * @param mixed $value
     * @return void
     * @throws InvalidCollectionParameterException
     */
    public function append(mixed $value): void
    {
        if (!($value instanceof $this->collectionClassType)) {
            // Object
            if (is_object($value)) {
                $type = get_class($value);
            } // Scalar type
            else {
                $type = gettype($value);
            }
            throw new InvalidCollectionParameterException($type, $this->collectionClassType);
        }
        parent::append($value);
    }
}