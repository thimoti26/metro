<?php

declare(strict_types=1);

/** @noinspection ServiceEntityRepository */

namespace App\ImportBoundedContext\Infrastructure\Orm\Repository;

use App\ImportBoundedContext\Domain\Model\Ligne\Ligne;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneArrayObject;
use App\Shared\Exception\InvalidCollectionParameterException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ligne>
 *
 * @method Ligne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ligne|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneArrayObject findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ligne::class);
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->createQueryBuilder('l')
            ->delete()
            ->getQuery()
            ->getResult();
        //@TODO reset autoIncrement
    }

    /**
     * @param LigneArrayObject $ligneArrayObject
     * @return LigneArrayObject
     */
    public function persistCollection(LigneArrayObject $ligneArrayObject): LigneArrayObject
    {
        /** @var Ligne $ligne */
        foreach ($ligneArrayObject as &$ligne) {
            $this->getEntityManager()->persist($ligne);
        }
        $this->getEntityManager()->flush();
        return $ligneArrayObject;
    }

    /**
     * @return LigneArrayObject
     * @throws InvalidCollectionParameterException
     */
    public function findAll(): LigneArrayObject
    {
        $lignes = parent::findAll();
        $ligneArrayObject = new LigneArrayObject();
        foreach ($lignes as $ligne) {
            $ligneArrayObject->append($ligne);
        }
        return $ligneArrayObject;
    }

    /**
     * @param Ligne $ligne
     * @return Ligne
     */
    public function persist(Ligne $ligne): Ligne
    {
        $this->getEntityManager()->persist($ligne);
        $this->getEntityManager()->flush();
        return $ligne;
    }
}
