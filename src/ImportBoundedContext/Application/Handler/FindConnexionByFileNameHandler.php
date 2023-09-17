<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Handler;

use App\ImportBoundedContext\Application\CQRS\Queries\FindConnexionByFileNameQuery;
use App\ImportBoundedContext\Domain\Dao\ConnexionFileDaoInterface;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\Shared\Application\CQRS\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class FindConnexionByFileNameHandler extends QueryHandler
{
    public function __construct(
        private readonly ConnexionFileDaoInterface $connexionDao
    )
    {
    }

    /**
     * @param FindConnexionByFileNameQuery $fileNameQuery
     * @return ConnexionArrayObject
     */
    public function __invoke(FindConnexionByFileNameQuery $fileNameQuery): ConnexionArrayObject
    {
        $fileName = $fileNameQuery->getFilename();
        return $this->connexionDao->findAllByFileName($fileName);
    }
}
