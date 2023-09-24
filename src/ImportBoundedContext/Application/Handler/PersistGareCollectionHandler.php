<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Handler;

use App\ImportBoundedContext\Application\CQRS\Commands\PersistGareArrayCommand;
use App\ImportBoundedContext\Domain\Dao\ConnexionDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Dao\GareDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\Shared\Application\CQRS\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PersistGareCollectionHandler extends QueryHandler
{
    /**
     * @param GareDatabaseDaoInterface $gareDao
     * @param ConnexionDatabaseDaoInterface $connexionDao
     */
    public function __construct(
        private readonly GareDatabaseDaoInterface $gareDao,
        private readonly ConnexionDatabaseDaoInterface $connexionDao
    )
    {
    }

    /**
     * @param PersistGareArrayCommand $gareArrayCommand
     * @return GareArrayObject
     */
    public function __invoke(PersistGareArrayCommand $gareArrayCommand): GareArrayObject
    {
        $gares = $gareArrayCommand->getGares();
        //Needed by gare FK
        $this->connexionDao->reset();
        $this->gareDao->reset();
        return $this->gareDao->persistCollection($gares);
    }
}
