<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Handler;

use App\ImportBoundedContext\Application\CQRS\Commands\PersistLigneArrayCommand;
use App\ImportBoundedContext\Domain\Dao\ConnexionDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Dao\LigneDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneArrayObject;
use App\Shared\Application\CQRS\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PersistLigneCollectionHandler extends QueryHandler
{
    /**
     * @param LigneDatabaseDaoInterface $ligneDao
     * @param ConnexionDatabaseDaoInterface $connexionDao
     */
    public function __construct(
        private readonly LigneDatabaseDaoInterface $ligneDao,
        private readonly ConnexionDatabaseDaoInterface $connexionDao
    )
    {
    }

    /**
     * @param PersistLigneArrayCommand $ligneArrayCommand
     * @return LigneArrayObject
     */
    public function __invoke(PersistLigneArrayCommand $ligneArrayCommand): LigneArrayObject
    {
        $lignes = $ligneArrayCommand->getLignes();
        //Needed by gare FK
        $this->connexionDao->reset();
        $this->ligneDao->reset();
        return $this->ligneDao->persistCollection($lignes);
    }
}
