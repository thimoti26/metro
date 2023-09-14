<?php

declare(strict_types=1);

namespace App\Shared\Application\CQRS;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Chaque Query a son propore Handler qui récupère
 * l'intension de lecture et qui effectue la collecte des données.
 */

abstract class QueryHandler
{

}
