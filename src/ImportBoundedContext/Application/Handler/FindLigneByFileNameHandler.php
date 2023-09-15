<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Handler;

use App\ImportBoundedContext\Application\CQRS\Queries\FindLigneByFileNameQuery;
use App\ImportBoundedContext\Domain\Dao\LigneFileDaoInterface;
use App\Shared\Application\CQRS\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler]
final class FindLigneByFileNameHandler extends QueryHandler
{
    public function __construct(
        private readonly LigneFileDaoInterface $ligneDao,
        private readonly SerializerInterface $serializer
    )
    {
    }

    /**
     * @param FindLigneByFileNameQuery $fileNameQuery
     * @return string
     */
    public function __invoke(FindLigneByFileNameQuery $fileNameQuery): string
    {
        $fileName = $fileNameQuery->getFilename();
        $lignes = $this->ligneDao->findAllByFileName($fileName);
        return $this->serializer->serialize($lignes, 'json');
    }
}
