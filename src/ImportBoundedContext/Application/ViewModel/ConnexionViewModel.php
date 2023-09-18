<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\ViewModel;

use App\ImportBoundedContext\Domain\Model\Connexion\Connexion;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionIdValueObject;
use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Ligne\Ligne;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\Annotation\Groups;

class ConnexionViewModel extends Connexion
{
    /**
     * @Groups({"default"})
     * @Model(type=ConnexionIdViewModel::class)
     * @var ConnexionIdViewModel|null
     */
    protected ?ConnexionIdValueObject $id;
    /**
     * @Groups({"default"})
     * @var LigneViewModel
     */
    protected Ligne $ligne;
    /**
     * @Groups({"default"})
     * @var GareViewModel
     */
    protected Gare $depart;
    /**
     * @Groups({"default"})
     * @var GareViewModel
     */
    protected Gare $arrive;
}
