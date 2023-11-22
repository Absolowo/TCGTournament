<?php

namespace App\Repository;

use App\Entity\Participante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Participante>
 *
 * @method Participante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participante[]    findAll()
 * @method Participante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participante::class);
    }

//    /**
//     * @return Participante[] Returns an array of Participante objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Participante
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findByName($text): array
    {
        $qb = $this->createQueryBuilder('p')
        ->andWhere('p.nombre LIKE :text')
        ->setParameter('text', '%' . $text . '%')
        ->getQuery();
        return $qb->execute();
    }
}
