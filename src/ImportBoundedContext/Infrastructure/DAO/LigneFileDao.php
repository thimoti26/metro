<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\DAO;

use App\ImportBoundedContext\Domain\Dao\LigneFileDaoInterface;
use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneArrayObject;
use App\ImportBoundedContext\Infrastructure\Exception\FileNotFoundException;
use ErrorException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class LigneFileDao implements LigneFileDaoInterface
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
     * @return LigneArrayObject
     * @throws FileNotFoundException
     */
    public function findAllByFileName(FileNameValueObject $fileNameValueObject): LigneArrayObject
    {
        try {
        $fp = file_get_contents($this->kernel->getProjectDir().'/Resources/'.$fileNameValueObject->getValue(), true);
        } catch (ErrorException $e) {
            throw new FileNotFoundException();
        }
        return $this->serializer->deserialize($fp, LigneArrayObject::class, 'csv', ['csv_delimiter' => ';']);
    }
}
