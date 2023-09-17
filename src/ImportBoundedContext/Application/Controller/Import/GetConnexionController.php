<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Controller\Import;

use App\ImportBoundedContext\Application\CQRS\Commands\PersistConnexionArrayCommand;
use App\ImportBoundedContext\Application\CQRS\Queries\FindConnexionByFileNameQuery;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;

class GetConnexionController extends AbstractController
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
     *     example="connexions.csv",
     *     description="connexion file path."
     * )
     * @OA\Response(
     *     response=200,
     *     description="test",
     *     @Model(type=ConnexionArrayObject::class)
     * )
     *
     * @param string $filePath
     * @return Response
     */
    public function __invoke(string $filePath): Response
    {
        $connexions = $this->handle(new FindConnexionByFileNameQuery(new FileNameValueObject($filePath)));

        $this->handle(new PersistConnexionArrayCommand($connexions));

        return JsonResponse::fromJsonString($this->serializer->serialize($connexions, 'json'));
    }
}