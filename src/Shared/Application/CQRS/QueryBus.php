<?php

declare(strict_types=1);

namespace App\Shared\Application\CQRS;

/**
 * En revanche, le QueryBus, contrairement au CommandBus, retourne un mixed qui sera la réponse pour le Controller.
 */
interface QueryBus
{
    /**
     * @param Query $query
     * @return mixed
     */
    function ask(Query $query): mixed;
}
