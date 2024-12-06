<?php

namespace App\Repository;

use App\Entity\AdminUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdminUser>
 *
 * @method AdminUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminUser[]    findAll()
 * @method AdminUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminUser::class);
    }

    public function countAll(): array
    {
        return $this->createQueryBuilder('count')
            ->select('COUNT(count.id)')
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?Admin:
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
