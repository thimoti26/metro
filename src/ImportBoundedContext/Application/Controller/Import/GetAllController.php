<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Controller\Import;

use App\ImportBoundedContext\Application\CQRS\Queries\FindConnexionByFileNameQuery;
use App\ImportBoundedContext\Application\CQRS\Queries\FindGareByFileNameQuery;
use App\ImportBoundedContext\Application\CQRS\Queries\FindLigneByFileNameQuery;
use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class GetAllController extends AbstractController
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
     * @OA\Response(
     *     response=200,
     *     description="200 if ok"
     * )
     *
     * @return Response
     */
    public function __invoke(): Response
    {
        $gareQuery       = new FindGareByFileNameQuery(new FileNameValueObject('Resources/gares.csv'));
        $ligneQuery      = new FindLigneByFileNameQuery(new FileNameValueObject('Resources/lignes.csv'));
        $connexionQuery  = new FindConnexionByFileNameQuery(new FileNameValueObject('Resources/connexions.csv'));


        $this->handle($gareQuery);
        $this->handle($ligneQuery);
        $this->handle($connexionQuery);

        return new Response();
    }
}
