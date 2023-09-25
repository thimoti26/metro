<?php

declare(strict_types=1);

namespace App\Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

class Entities
{
    //Infra entities must implements domain entities
    public function testInfraEntitiesMustImplementsDomainEntities(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::namespace('/^App\\\.*\\\Infrastructure\\\Model\\\.*/', true))
            ->shouldExtend()
            ->classes(Selector::namespace('/^App\\\.*\\\Domain\\\Model\\\.*/', true))
            ->because('Infra Entities must extends Domain Entitites.');
    }
}
