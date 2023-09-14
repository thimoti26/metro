<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Handler;

use App\ImportBoundedContext\Application\CQRS\FindGareByFileNameQuery;
use App\ImportBoundedContext\Domain\Dao\GareFileDaoInterface;
use App\Shared\Application\CQRS\QueryHandler;
use JsonException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

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
     * @return string
     * @throws JsonException
     */
    public function __invoke(FindGareByFileNameQuery $fileNameQuery): string
    {
        $fileName = $fileNameQuery->getFilename();
        $gares = $this->gareDao->findAllByFileName($fileName);
        dd($gares);
        return json_encode($results, JSON_THROW_ON_ERROR);
    }
}
