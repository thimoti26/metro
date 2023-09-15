<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Handler;

use App\ImportBoundedContext\Application\CQRS\Queries\FindConnexionByFileNameQuery;
use App\ImportBoundedContext\Domain\Dao\ConnexionFileDaoInterface;
use App\Shared\Application\CQRS\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler]
final class FindConnexionByFileNameHandler extends QueryHandler
{
    public function __construct(
        private readonly ConnexionFileDaoInterface $connexionDao,
        private readonly SerializerInterface $serializer
    )
    {
    }

    /**
     * @param FindConnexionByFileNameQuery $fileNameQuery
     * @return string
     */
    public function __invoke(FindConnexionByFileNameQuery $fileNameQuery): string
    {
        $fileName = $fileNameQuery->getFilename();
        $connexions = $this->connexionDao->findAllByFileName($fileName);
        return $this->serializer->serialize($connexions, 'json');
    }
}
