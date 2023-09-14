<?php

declare(strict_types=1);

namespace App\Shared\Orm\Entity;

use App\ImportBoundedContext\Infrastructure\Repository\LigneEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneEntityRepository::class)]
class LigneEntity implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $name = null;

    #[ORM\Column]
    protected ?float $speed = null;

    #[ORM\Column]
    protected ?float $spacing = null;

    #[ORM\Column(length: 255)]
    protected ?string $color = null;

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
    public function getSpeed(): ?float
    {
        return $this->speed;
    }

    /**
     * @return float|null
     */
    public function getSpacing(): ?float
    {
        return $this->spacing;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }
}
