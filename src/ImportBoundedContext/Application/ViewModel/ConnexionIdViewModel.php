<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\ViewModel;

use App\ImportBoundedContext\Model\Model\Connexion\ConnexionIdValueObject;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @OA\Schema(type="string")
 */
class ConnexionIdViewModel extends ConnexionIdValueObject
{
    /**
     * @Groups({"default"})
     * @var int
     */
    protected int $value;
}
