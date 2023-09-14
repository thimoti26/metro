<?php

declare(strict_types=1);

namespace App\Shared\Application\CQRS;

/**
 * Les commandes représentent donc les intentions d'écriture dans le système.
 * Chaque commande devra implémenter l'interface Command et définir des
 * attributs comme le ferai un modèle pour stocker les informations de la demande.
 *
 * @example Une commande pour bloquer un compte utilisateur pourrait avoir un champ userId contenant l'id de l'utilisateur à bloquer.
 */
interface Command
{

}
