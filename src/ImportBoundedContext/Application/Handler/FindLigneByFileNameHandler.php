<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Handler;

use App\ImportBoundedContext\Application\CQRS\Queries\FindLigneByFileNameQuery;
use App\ImportBoundedContext\Domain\Dao\LigneFileDaoInterface;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneArrayObject;
use App\Shared\Application\CQRS\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler]
final class FindLigneByFileNameHandler extends QueryHandler
{
    public function __construct(
        private readonly LigneFileDaoInterface $ligneDao
    )
    {
    }

    /**
     * @param FindLigneByFileNameQuery $fileNameQuery
     * @return LigneArrayObject
     */
    public function __invoke(FindLigneByFileNameQuery $fileNameQuery): LigneArrayObject
    {
        $fileName = $fileNameQuery->getFilename();
        return $this->ligneDao->findAllByFileName($fileName);
    }
}
