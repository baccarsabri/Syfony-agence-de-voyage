<?php

namespace App\Repository;

use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ville|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ville|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ville[]    findAll()
 * @method Ville[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ville::class);
    }

    /**
     * @return Ville[] Returns an array of Ville objects
     */
    
    public function find_ville_etape()
    {
        $result_manager=$this->getEntityManager();
        $q_ville_etape=$result_manager->createQuery(
            'SELECT v,e FROM App\Entity\Ville v LEFT JOIN v.etapes e');
        return $q_ville_etape->getResult();      
    }
    public function find_ville_order()
    {
        $result_manager=$this->getEntityManager();
        $q_ville_etape=$result_manager->createQuery(
            'SELECT v FROM App\Entity\Ville v  WHERE v IN 
            (SELECT u FROM App\Entity\Ville u JOIN u.etapes e WHERE e.ordre_etape=1)');
        return $q_ville_etape->getResult();      
    }
 
     /**
      * @return Ville[] Returns an array of Ville objects
      */
    
    public function findByDestination($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.dest_ville = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Ville
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
