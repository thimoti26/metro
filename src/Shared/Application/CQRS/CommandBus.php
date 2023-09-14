<?php

declare(strict_types=1);

namespace App\Shared\Application\CQRS;

/**
 * Le pattern CQRS recommande de créer un Bus de commande pour pouvoir facilement y intégrer des middleware par la suite.
 * Un middleware possible sur le Bus des commandes serait un middleware transactionel pour une base de données relationelle.
 */
interface CommandBus
{
    /**
     * @param Command $command
     * @return void
     */
    function dispatch(Command $command): void;
}
