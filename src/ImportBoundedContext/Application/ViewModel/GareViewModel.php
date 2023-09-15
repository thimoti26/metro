<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\ViewModel;

use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\Annotation\Groups;

class GareViewModel extends Gare
{
    /**
     * @Groups({"default"})
     * @Model(type=GareIdViewModel::class)
     * @var GareIdViewModel|null
     */
    protected ?GareIdValueObject $id;
    /**
     * @Groups({"default"})
     * @var string
     */
    protected string $nom;
    /**
     * @Groups({"default"})
     * @var float
     */
    protected float $longitude;
    /**
     * @Groups({"default"})
     * @var float
     */
    protected float $latitude;
}
