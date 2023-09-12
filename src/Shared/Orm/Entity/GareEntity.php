<?php

namespace App\Shared\Orm\Entity;

use App\Shared\Orm\Repository\GareEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GareEntityRepository::class)]
class GareEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\OneToMany(mappedBy: 'departs', targetEntity: ConnexionEntity::class)]
    private Collection $departs;

    #[ORM\OneToMany(mappedBy: 'arrive', targetEntity: ConnexionEntity::class)]
    private Collection $arrives;

    public function __construct()
    {
        $this->departs = new ArrayCollection();
        $this->arrives = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return Collection<int, ConnexionEntity>
     */
    public function getDeparts(): Collection
    {
        return $this->departs;
    }

    public function addDeparts(ConnexionEntity $departs): static
    {
        if (!$this->departs->contains($departs)) {
            $this->departs->add($departs);
            $departs->setDeparts($this);
        }

        return $this;
    }

    public function removeDeparts(ConnexionEntity $departs): static
    {
        if ($this->departs->removeElement($departs)) {
            // set the owning side to null (unless already changed)
            if ($departs->getDeparts() === $this) {
                $departs->setDeparts(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ConnexionEntity>
     */
    public function getArrives(): Collection
    {
        return $this->arrives;
    }

    public function addArrive(ConnexionEntity $arrive): static
    {
        if (!$this->arrives->contains($arrive)) {
            $this->arrives->add($arrive);
            $arrive->setArrive($this);
        }

        return $this;
    }

    public function removeArrive(ConnexionEntity $arrive): static
    {
        if ($this->arrives->removeElement($arrive)) {
            // set the owning side to null (unless already changed)
            if ($arrive->getArrive() === $this) {
                $arrive->setArrive(null);
            }
        }

        return $this;
    }
}
