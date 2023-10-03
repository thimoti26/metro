<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\DAO;

use App\ImportBoundedContext\Domain\Dao\ConnexionFileDaoInterface;
use App\ImportBoundedContext\Domain\Model\Connexion\Connexion;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Ligne\Ligne;
use App\ImportBoundedContext\Infrastructure\Exception\FileNotFoundException;
use App\ImportBoundedContext\Infrastructure\Model\File\Connexion\Connexion as ConnexionInfra;
use App\ImportBoundedContext\Infrastructure\Model\File\Connexion\ConnexionArrayObject as ConnexionArrayInfra;
use App\Shared\Exception\InvalidCollectionParameterException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ConnexionFileDao implements ConnexionFileDaoInterface
{
    /**
     * @param SerializerInterface $serializer
     * @param KernelInterface $kernel
     * @param GareDatabaseDao $gareDatabaseDao
     * @param LigneDatabaseDao $ligneDatabaseDao
     */
    public function __construct(
        private SerializerInterface  $serializer,
        private KernelInterface      $kernel,
        private GareDatabaseDao $gareDatabaseDao,
        private LigneDatabaseDao $ligneDatabaseDao
    )
    {
    }

    /**
     * @param FileNameValueObject $fileNameValueObject
     * @return ConnexionArrayObject
     * @throws FileNotFoundException|InvalidCollectionParameterException
     */
    public function findAllByFileName(FileNameValueObject $fileNameValueObject): ConnexionArrayObject
    {
        $fileData = file_get_contents($this->kernel->getProjectDir() . '/Resources/' . $fileNameValueObject->getValue(), true);

        if (false === $fileData) {
            throw new FileNotFoundException($fileNameValueObject);
        }

        $connexions = new ConnexionArrayObject();

        /** @var ConnexionArrayInfra $datasInfra */
        $datasInfra = $this->serializer->deserialize($fileData, ConnexionArrayInfra::class, 'csv', ['csv_delimiter' => ';']);

        $gares = $this->gareDatabaseDao->findAll();

        $lignes = $this->ligneDatabaseDao->findAll();

        /** @var ConnexionInfra $dataInfra */
        foreach ($datasInfra as $dataInfra) {
            $departFound = false;
            $arrriveFound = false;
            $ligneFound = false;
            /** @var Ligne $ligne */
            foreach ($lignes as $ligne) {
                if ($ligne->getNom() === $dataInfra->getLigne()) {
                    $ligneFound = $ligne;
                    break;
                }
            }
            /** @var Gare $gare */
            foreach ($gares as $gare) {
                if ($gare->getNom() === $dataInfra->getDepart()) {
                    $departFound = $gare;
                    continue;
                }
                if ($gare->getNom() === $dataInfra->getArrive()) {
                    $arrriveFound = $gare;
                    continue;
                }
                if ((false !== $departFound) && (false !== $arrriveFound)) {
                    break;
                }
            }
            $connexions->append(
                new Connexion(
                    null,
                    $ligneFound,
                    $departFound,
                    $arrriveFound
                )
            );
        }

        return $connexions;
    }
}
