<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\ViewModel;

use App\ImportBoundedContext\Domain\Model\Connexion\Connexion;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionIdValueObject;
use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneIdValueObject;
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
     * @var LigneIdViewModel
     */
    protected LigneIdValueObject $ligne;
    /**
     * @Groups({"default"})
     * @var GareIdViewModel
     */
    protected GareIdValueObject $depart;
    /**
     * @Groups({"default"})
     * @var GareIdViewModel
     */
    protected GareIdValueObject $arrive;
}
