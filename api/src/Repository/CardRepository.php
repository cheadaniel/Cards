<?php

namespace App\Repository;

use App\Entity\Card;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Card>
 *
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Card::class);
    }

    public function save(Card $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Card $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCardName(string $cardName)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Name = :cardName')
            ->setParameter('cardName', $cardName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findCardsByGameAndExtension(string $gameName, string $extensionName)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.Game_id', 'g')
            ->innerJoin('c.Extension_id', 'e')
            ->where('g.Name = :gameName')
            ->andWhere('e.Name = :extensionName')
            ->setParameters(['gameName' => $gameName, 'extensionName' => $extensionName])
            ->getQuery()
            ->getResult();
    }

    public function findMinAndMaxCardIds()
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        // Sélectionnez le minimum et le maximum des ID de la table 'Card'
        $queryBuilder->select('MIN(c.id) as minId', 'MAX(c.id) as maxId')
            ->from('App\Entity\Card', 'c');

        $query = $queryBuilder->getQuery();
        $result = $query->getOneOrNullResult();

        if (!$result) {
            return [
                'minId' => null,
                'maxId' => null,
            ];
        }

        return [
            'minId' => $result['minId'],
            'maxId' => $result['maxId'],
        ];
    }

    //    /**
    //     * @return Card[] Returns an array of Card objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Card
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
