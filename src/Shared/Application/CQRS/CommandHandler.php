<?php

declare(strict_types=1);

namespace App\Shared\Application\CQRS;

/**
 * Pour chaque commande,
 * on crée un Handler qui est chargé d'effectuer une action dans le système.
 *
 * @example Bloquage d'un utilisateur :
 * l'Handler de cette commande pourrait éventuelement avoir un UserRepository
 * en dépendance et faire un appel à une fonction updateUser de ce dernier.
 */
interface CommandHandler
{

}
