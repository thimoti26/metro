<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Controller\Import;

use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneArrayObject;
use App\ImportBoundedContext\Domain\Service\ImportService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class GetConnexionController extends AbstractController
{

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ImportService $importService,
        private readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    /**
     * @OA\Tag(name="import")
     * @OA\Response(
     *     response=200,
     *     description="test",
     *     @Model(type=App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject::class)
     * )
     *
     * @return Response
     */
    public function __invoke(): Response
    {
        $fp = file_get_contents('../Resources/connexions.csv', true);
        $connexions = $this->serializer->deserialize($fp, ConnexionArrayObject::class, 'csv', ['csv_delimiter' => ';']);
        $this->importService->importConnexion($connexions);

        return new Response();
    }
}
