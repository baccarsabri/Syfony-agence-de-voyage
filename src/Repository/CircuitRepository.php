<?php

namespace App\Repository;

use App\Entity\Circuit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Circuit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Circuit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Circuit[]    findAll()
 * @method Circuit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CircuitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry )
    {
        parent::__construct($registry, Circuit::class);
    }
     /**
     * @return Circuit[] Returns an array of Circuit objects
     */
    
    public function delete_circuit_byduree()
    { $result_manager=$this->getEntityManager();
        $q_circuit=$result_manager->createQuery(
            'DELETE FROM App\Entity\circuit c  where c.duree_circuit<8');
        return $q_circuit->getResult(); 
       
    }
    /**
    * @return Circuit[] Returns an array of Circuit objects
    */
    
    public function find_Circuits()
    {
        $result_manager=$this->getEntityManager();
        $Circuit=$result_manager->createQuery(
            'SELECT c FROM App\Entity\Circuit c');
        return $Circuit->getResult();      
    }
    

    // /**
    //  * @return Circuit[] Returns an array of Circuit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Circuit
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
