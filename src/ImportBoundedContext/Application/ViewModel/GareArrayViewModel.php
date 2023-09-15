<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\ViewModel;

use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(type="array", @OA\Items(ref=@Model(type=GareViewModel::class)))
 */
class GareArrayViewModel extends GareArrayObject
{
}
