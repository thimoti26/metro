<?php

declare(strict_types=1);

namespace App\Shared\Orm\Entity;

use App\ImportBoundedContext\Infrastructure\Orm\Repository\ConnexionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnexionRepository::class)]
class ConnexionEntity implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    protected ?LigneEntity $ligne = null;

    #[ORM\ManyToOne(inversedBy: 'arrive')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?GareEntity $depart = null;

    #[ORM\ManyToOne(inversedBy: 'arrives')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?GareEntity $arrive = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return LigneEntity|null
     */
    public function getLigne(): ?LigneEntity
    {
        return $this->ligne;
    }

    /**
     * @return GareEntity|null
     */
    public function getDepart(): ?GareEntity
    {
        return $this->depart;
    }

    /**
     * @return GareEntity|null
     */
    public function getArrive(): ?GareEntity
    {
        return $this->arrive;
    }
}
