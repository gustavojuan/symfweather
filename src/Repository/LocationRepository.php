<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function save(Location $entity, bool $flush = false)
    {
        $em = $this->getEntityManager();
        $em->persist($entity);

        if ($flush) {
            $em->flush();
        }
    }

    public function remove(Location $entity, bool $flush = false)
    {
        $em = $this->getEntityManager();
        $em->remove($entity);

        if ($flush) {
            $em->flush();
        }
    }


    public function findOneByName(string $name): ?Location
    {
        $qb = $this->createQueryBuilder('l');

        $qb
            ->where('l.name = :name')
            ->setParameter('name', $name)
            // ->andWhere('l.countryCode = :countryCode')
            // ->setParameter('countryCode', 'pl')
        ;

        $query = $qb->getQuery();
        $entity = $query->getOneOrNullResult();

        return $entity;
    }

    public function findAllWithForecats(): array
    {
        $qb = $this->createQueryBuilder('l');
        $qb
            ->select(['l', 'f'])
            ->leftJoin('l.forecasts', 'f');

        $query = $qb->getQuery();

        $result = $query->getResult();

        return $result;
    }

    //    /**
    //     * @return Location[] Returns an array of Location objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Location
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
