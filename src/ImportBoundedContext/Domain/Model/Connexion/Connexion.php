<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Domain\Model\Connexion;

use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Gare\GareIdValueObject;
use App\ImportBoundedContext\Domain\Model\Ligne\Ligne;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneIdValueObject;

class Connexion
{
    /** @var ConnexionIdValueObject|null */
    private ?ConnexionIdValueObject $id;
    /** @var LigneIdValueObject */
    private LigneIdValueObject $ligne;
    /** @var GareIdValueObject */
    private GareIdValueObject $depart;
    /** @var GareIdValueObject */
    private GareIdValueObject $arrive;

    /**
     * @param ConnexionIdValueObject|null $id
     * @param LigneIdValueObject $ligne
     * @param GareIdValueObject $depart
     * @param GareIdValueObject $arrive
     */
    public function __construct(?ConnexionIdValueObject $id, LigneIdValueObject $ligne, GareIdValueObject $depart, GareIdValueObject $arrive)
    {
        $this->id = $id;
        $this->ligne = $ligne;
        $this->depart = $depart;
        $this->arrive = $arrive;
    }

    /**
     * @return ConnexionIdValueObject|null
     */
    public function getId(): ?ConnexionIdValueObject
    {
        return $this->id;
    }

    /**
     * @return LigneIdValueObject
     */
    public function getLigne(): LigneIdValueObject
    {
        return $this->ligne;
    }

    /**
     * @return GareIdValueObject
     */
    public function getDepart(): GareIdValueObject
    {
        return $this->depart;
    }

    /**
     * @return GareIdValueObject
     */
    public function getArrive(): GareIdValueObject
    {
        return $this->arrive;
    }
}
