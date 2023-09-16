<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Handler;

use App\ImportBoundedContext\Application\CQRS\Queries\FindGareByFileNameQuery;
use App\ImportBoundedContext\Domain\Dao\GareFileDaoInterface;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\Shared\Application\CQRS\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler]
final class FindGareByFileNameHandler extends QueryHandler
{
    public function __construct(
        private readonly GareFileDaoInterface $gareDao
    )
    {
    }

    /**
     * @param FindGareByFileNameQuery $fileNameQuery
     * @return GareArrayObject
     */
    public function __invoke(FindGareByFileNameQuery $fileNameQuery): GareArrayObject
    {
        $fileName = $fileNameQuery->getFilename();
        return $this->gareDao->findAllByFileName($fileName);
    }
}
