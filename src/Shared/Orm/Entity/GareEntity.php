<?php

declare(strict_types=1);

namespace App\Shared\Orm\Entity;

use App\ImportBoundedContext\Infrastructure\Orm\Repository\GareRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GareRepository::class)]
class GareEntity implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $name = null;

    #[ORM\Column]
    protected ?float $longitude = null;

    #[ORM\Column]
    protected ?float $latitude = null;

    #[ORM\OneToMany(mappedBy: 'departs', targetEntity: ConnexionEntity::class)]
    protected Collection $departs;

    #[ORM\OneToMany(mappedBy: 'arrive', targetEntity: ConnexionEntity::class)]
    protected Collection $arrives;

    public function __construct()
    {
        $this->departs = new ArrayCollection();
        $this->arrives = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @return Collection
     */
    public function getDeparts(): Collection
    {
        return $this->departs;
    }

    /**
     * @return Collection
     */
    public function getArrives(): Collection
    {
        return $this->arrives;
    }
}
