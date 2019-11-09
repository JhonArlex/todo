<?php

namespace App\Repository;

use App\Entity\Tareas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Tareas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tareas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tareas[]    findAll()
 * @method Tareas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TareasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tareas::class);
    }

    // /**
    //  * @return Tareas[] Returns an array of Tareas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tareas
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllMatching(string $query, int $limit = 5)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM tareas t
            WHERE t.nombre LIKE :query
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['query' => '%'.$query.'%']);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
}
