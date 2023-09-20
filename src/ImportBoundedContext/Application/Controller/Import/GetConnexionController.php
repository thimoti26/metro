<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Controller\Import;

use App\ImportBoundedContext\Application\CQRS\Commands\PersistConnexionArrayCommand;
use App\ImportBoundedContext\Application\CQRS\Queries\FindConnexionByFileNameQuery;
use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use App\ImportBoundedContext\Application\ViewModel\ConnexionArrayViewModel;
use App\Shared\Domain\Response\ApiResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use App\Shared\Symfony\Controller\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     *
     *      ),
     *     example="connexions.csv",
     *     description="connexion file path."
     * )
     * @OA\Response(
     *     response=200,
     *     description="test",
     *     @Model(type=ConnexionArrayViewModel::class)
     * )
     *
     * @param string $filePath
     * @return Response
     */
    public function __invoke(string $filePath): Response
    {
        $connexions = $this->handle(new FindConnexionByFileNameQuery(new FileNameValueObject($filePath)));

        $this->handle(new PersistConnexionArrayCommand($connexions));

        return new Response(
            new ApiResponse(0, 'test', $connexions),
            $this->serializer
        );
    }
}
