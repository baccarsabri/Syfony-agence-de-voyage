<?php

namespace App\Repository;

use App\Entity\Etape;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Etape|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etape|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etape[]    findAll()
 * @method Etape[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtapeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etape::class);
    }
     
    
    
    public function delete()
    {
        return $this->createQueryBuilder('e')
            ->delete(Etape::class ,'e')
            
            ->where('e.duree_etape < 8'  )
            
            ->getQuery()
            ->execute()
        ;
    }
    public function modif()
    {
        
        $em=$this->getEntityManager();
        //pour été1_local
        $m_etape=$em->getRepository(Etape::class )->findOneBy(array('circuit_etape'=> 1));
        if ($m_etape != null){
        foreach ($m_etape as $s){
        $s->setDureeEtape(3);
        }
    }
        //pour été2_local 
        $m_etape=$em->getRepository(Etape::class )->findOneBy(array('circuit_etape'=> 2));
        if ($m_etape != null){
        $m_etape->setDureeEtape(3);
        }
        $em->flush();


    }
     /**
     * @return Etape[] Returns an array of Etape objects
     */
    
    
    public function findDureelonguehurghada(): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere("e.ville_etape = 13 ")
            
            ->orderBy('e.duree_etape', 'DESC')
            
            ->getQuery()
            ->getResult()
        ;
    }
    /**
      * @return Etape[] Returns an array of Etape objects
      */
    
      public function findByCircuit($value)
      {
          return $this->createQueryBuilder('c')
              ->andWhere('c.circuit_etape = :val')
              ->setParameter('val', $value)
              ->orderBy('c.id', 'ASC')
              
              ->getQuery()
              ->getResult()
          ;
      }
    
    // /**
    //  * @return Etape[] Returns an array of Etape objects
    //  */
    /*
    
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Etape
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
