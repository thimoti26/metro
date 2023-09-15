<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Handler;

use App\ImportBoundedContext\Application\CQRS\Queries\FindGareByFileNameQuery;
use App\ImportBoundedContext\Domain\Dao\GareFileDaoInterface;
use App\Shared\Application\CQRS\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler]
final class FindGareByFileNameHandler extends QueryHandler
{
    public function __construct(
        private readonly GareFileDaoInterface $gareDao,
        private readonly SerializerInterface $serializer
    )
    {
    }

    /**
     * @param FindGareByFileNameQuery $fileNameQuery
     * @return string
     */
    public function __invoke(FindGareByFileNameQuery $fileNameQuery): string
    {
        $fileName = $fileNameQuery->getFilename();
        $gares = $this->gareDao->findAllByFileName($fileName);
        return $this->serializer->serialize($gares, 'json');
    }
}
