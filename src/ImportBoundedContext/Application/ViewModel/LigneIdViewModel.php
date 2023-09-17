<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\ViewModel;

use App\ImportBoundedContext\Domain\Model\Ligne\LigneIdValueObject;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @OA\Schema(type="int")
 */
class LigneIdViewModel extends LigneIdValueObject
{
    /**
     * @Groups({"default"})
     * @var int
     */
    protected int $value;
}
