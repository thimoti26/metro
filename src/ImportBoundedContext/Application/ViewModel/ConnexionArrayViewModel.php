<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\ViewModel;

use App\ImportBoundedContext\Model\Model\Connexion\ConnexionArrayObject;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(type="array", @OA\Items(ref=@Model(type=ConnexionViewModel::class)))
 */
class ConnexionArrayViewModel extends ConnexionArrayObject
{
}
