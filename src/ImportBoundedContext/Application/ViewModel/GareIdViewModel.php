<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\ViewModel;

use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @OA\Schema(type="integer")
 */
class GareIdViewModel extends GareIdValueObject
{
    /**
     * @Groups({"default"})
     * @var int
     */
    protected int $value;
}
