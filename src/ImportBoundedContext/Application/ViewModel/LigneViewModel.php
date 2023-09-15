<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\ViewModel;

use App\ImportBoundedContext\Domain\Model\Ligne\Ligne;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneIdValueObject;
use Symfony\Component\Serializer\Annotation\Groups;
use Nelmio\ApiDocBundle\Annotation\Model;

class LigneViewModel extends Ligne
{
    /**
     * @Groups({"default"})
     * @Model(type=LigneIdViewModel::class)
     * @var LigneIdViewModel|null
     */
    protected ?LigneIdValueObject $id;
    /**
     * @Groups({"default"})
     * @var string
     */
    protected string $nom;
    /**
     * @Groups({"default"})
     * @var float
     */
    protected float $vitesse;
    /**
     * @Groups({"default"})
     * @var float
     */
    protected float $intervalle;
    /**
     * @Groups({"default"})
     * @var string
     */
    protected string $couleur;
}
