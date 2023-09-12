<?php

namespace App\Shared\Orm\Entity;

use App\Shared\Orm\Repository\ConnexionEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnexionEntityRepository::class)]
class ConnexionEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?LigneEntity $ligne = null;

    #[ORM\ManyToOne(inversedBy: 'arrive')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GareEntity $depart = null;

    #[ORM\ManyToOne(inversedBy: 'arrives')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GareEntity $arrive = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLigne(): ?LigneEntity
    {
        return $this->ligne;
    }

    public function setLigne(?LigneEntity $ligne): static
    {
        $this->ligne = $ligne;

        return $this;
    }

    public function getDepart(): ?GareEntity
    {
        return $this->depart;
    }

    public function setDepart(?GareEntity $depart): static
    {
        $this->depart = $depart;

        return $this;
    }

    public function getArrive(): ?GareEntity
    {
        return $this->arrive;
    }

    public function setArrive(?GareEntity $arrive): static
    {
        $this->arrive = $arrive;

        return $this;
    }
}
