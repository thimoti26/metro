<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Controller\Import;

use App\ImportBoundedContext\Application\CQRS\Commands\PersistGareArrayCommand;
use App\ImportBoundedContext\Application\CQRS\Queries\FindGareByFileNameQuery;
use App\ImportBoundedContext\Application\ViewModel\GareArrayViewModel;
use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;

class GetGareController extends AbstractController
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $messageBus
     * @param SerializerInterface $serializer
     */
    public function __construct(
        MessageBusInterface                  $messageBus,
        private readonly SerializerInterface $serializer
    )
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
     *     example="gares.csv",
     *     description="gare file path."
     * )
     * @OA\Response(
     *     response=200,
     *     description="test",
     *     @Model(type=GareArrayViewModel::class, groups={"default"})
     * )
     *
     * @param string $filePath
     * @return Response
     */
    public function __invoke(string $filePath): Response
    {
        $gares = $this->handle(new FindGareByFileNameQuery(new FileNameValueObject($filePath)));

        $this->handle(new PersistGareArrayCommand($gares));

        return JsonResponse::fromJsonString($this->serializer->serialize($gares, 'json'));
    }
}
