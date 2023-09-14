<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Infrastructure\DAO;

use App\ImportBoundedContext\Domain\Dao\GareFileDaoInterface;
use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class GareFileDao implements GareFileDaoInterface
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
     * @return GareArrayObject
     */
    public function findAllByFileName(FileNameValueObject $fileNameValueObject): GareArrayObject
    {
        $fp = file_get_contents($this->kernel->getProjectDir().'/'.$fileNameValueObject->getValue(), true);
        return $this->serializer->deserialize($fp, GareArrayObject::class, 'csv', ['csv_delimiter' => ';']);
    }
}
