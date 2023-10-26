<?php

declare(strict_types=1);

namespace App\Tests\Units\Symfony\Normalizer\ApiResponse\Fixtures;

use App\Shared\Domain\Model\Entity;

class Content implements Entity
{
    /** @var string */
    private string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
