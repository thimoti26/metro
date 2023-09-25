<?php

declare(strict_types=1);

namespace App\Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

class Layers
{
    /**
     * @return Rule
     */
    public function testDomainDoesNotDependsOnOtherLayers(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::namespace('/^App\\\.*\\\Domain\\\.*/', true))
            ->shouldNotDependOn()
            ->classes(
                Selector::namespace('/^App\\\.*\\\Application\\\.*/', true),
                Selector::namespace('/^App\\\.*\\\Infrastructure\\\.*/', true)
            )
            ->because('Everythings in Domain Layer needs to be independent of App / Infra (maybe need Interface (Hexagonal Architecture)).');
    }
}
