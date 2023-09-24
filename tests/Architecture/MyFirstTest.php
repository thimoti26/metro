<?php

declare(strict_types=1);

namespace App\Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

class MyFirstTest
{
    public function test_domain_does_not_depend_on_other_layers(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::namespace('^App\\([^\/]*)\\Domain\\.*', true))
            ->shouldNotDependOn()
            ->classes(
                Selector::namespace('App\Application'),
                Selector::namespace('App\Infrastructure'),
                Selector::classname('/^vendor\\\.*\\\ForbiddenSubfolder\\\.*/', true)
            );
    }
    public function test_domain_entities_must_depends_on_interface_entities(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::namespace('^App\\([^\/]*)\\Domain\\.*', true))
            ->shouldImplement()
            ->classes(
                Selector::namespace('App\Domain')
            );
//            ->because('this will break our architecture, implement it another way! see /docs/howto.md');
    }
}
