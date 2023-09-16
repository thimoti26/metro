<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Handler;

use App\ImportBoundedContext\Application\CQRS\Commands\PersistConnexionArrayCommand;
use App\ImportBoundedContext\Domain\Dao\ConnexionDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\Shared\Application\CQRS\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PersistConnexionCollectionHandler extends QueryHandler
{
    public function __construct(
        private readonly ConnexionDatabaseDaoInterface $connexionDao
    )
    {
    }

    /**
     * @param PersistConnexionArrayCommand $connexionArrayCommand
     * @return ConnexionArrayObject
     */
    public function __invoke(PersistConnexionArrayCommand $connexionArrayCommand): ConnexionArrayObject
    {
        $connexions = $connexionArrayCommand->getConnexions();
        return $this->connexionDao->persistCollection($connexions);
    }
}
