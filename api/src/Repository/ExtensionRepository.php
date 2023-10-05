<?php

namespace App\Repository;

use App\Entity\Extension;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Extension>
 *
 * @method Extension|null find($id, $lockMode = null, $lockVersion = null)
 * @method Extension|null findOneBy(array $criteria, array $orderBy = null)
 * @method Extension[]    findAll()
 * @method Extension[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExtensionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Extension::class);
    }

    public function save(Extension $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Extension $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByExtensionName(string $extensionName)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.Name = :extensionName')
            ->setParameter('extensionName', $extensionName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findExtensionsByGameName(string $gameName)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.Game_id', 'g')
            ->andWhere('g.Name = :gameName')
            ->setParameter('gameName', $gameName)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Extension[] Returns an array of Extension objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Extension
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
