<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Controller\Import;

use App\ImportBoundedContext\Application\CQRS\Queries\FindLigneByFileNameQuery;
use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use App\ImportBoundedContext\Application\ViewModel\LigneArrayViewModel;


class GetLigneController extends AbstractController
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @OA\Tag(name="import")
     * @OA\Parameter(
     *     name="filePath",
     *     in="path",
     *      @OA\Schema(
     *          type="string"
     *      ),
     *     example="lignes.csv",
     *     description="ligne file path."
     * )
     * @OA\Response(
     *     response=200,
     *     description="test",
     *     @Model(type=LigneArrayViewModel::class, groups={"default"})
     * )
     *
     * @param string $filePath
     * @return Response
     */
    public function __invoke(string $filePath): Response
    {
        $lignes = $this->handle(new FindLigneByFileNameQuery(new FileNameValueObject($filePath)));

        return JsonResponse::fromJsonString($lignes);
    }
}
