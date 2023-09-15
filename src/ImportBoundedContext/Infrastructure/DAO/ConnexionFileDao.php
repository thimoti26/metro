<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\DAO;

use App\ImportBoundedContext\Domain\Dao\ConnexionFileDaoInterface;
use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\ImportBoundedContext\Infrastructure\Exception\FileNotFoundException;
use ErrorException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ConnexionFileDao implements ConnexionFileDaoInterface
{
    /**
     * @param SerializerInterface $serializer
     * @param KernelInterface $kernel
     */
    public function __construct(
        private SerializerInterface $serializer,
        private KernelInterface $kernel
    )
    {
    }

    /**
     * @param FileNameValueObject $fileNameValueObject
     * @return ConnexionArrayObject
     * @throws FileNotFoundException
     */
    public function findAllByFileName(FileNameValueObject $fileNameValueObject): ConnexionArrayObject
    {
        try {
            $fp = file_get_contents($this->kernel->getProjectDir().'/Resources/'.$fileNameValueObject->getValue(), true);
        } catch (ErrorException $e) {
            throw new FileNotFoundException();
        }
        return $this->serializer->deserialize($fp, ConnexionArrayObject::class, 'csv', ['csv_delimiter' => ';']);
    }
}
