<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Handler;

use App\ImportBoundedContext\Application\CQRS\Commands\PersistGareArrayCommand;
use App\ImportBoundedContext\Domain\Dao\GareDatabaseDaoInterface;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\Shared\Application\CQRS\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PersistGareCollectionHandler extends QueryHandler
{
    public function __construct(
        private readonly GareDatabaseDaoInterface $gareDao
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
        $this->gareDao->reset();
        return $this->gareDao->persistCollection($gares);
    }
}
