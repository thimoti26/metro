<?php

declare(strict_types=1);

namespace App\Shared\Application\CQRS;

/**
 * Les Query représentent, des intentions de lecture.
 * Chaque Query devra implémenter l'interface Query et définir
 * des attributs qui représenteront les données utiles pour l'élaboration de la Query.

 * @example : Une Query qui retourne une liste paginée d'utilisateurs, deux attributs possibles seront: pageNumber et pageSize.
 */
interface Query
{

}
