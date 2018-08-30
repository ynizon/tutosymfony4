<?php

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Materiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Materiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Materiel[]    findAll()
 * @method Materiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterielRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Materiel::class);
    }

//    /**
//     * @return Materiel[] Returns an array of Materiel objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Materiel
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
	
	public function getRandom(){
		//Avec le QueryBuilder
		return $this->createQueryBuilder('materiel')
            ->andWhere('materiel.id != :val')
            ->setParameter('val', 5)
            ->orderBy('materiel.nom', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
		
		//Avec Doctrine: En DSL
		$query = $this->_em->createQuery('SELECT * FROM materiel WHERE id != 5 order by nom LIMIT 0,100');
		$results = $query->getResult();
		return $results;
	}
	
	public function findLikeNom($s){
		//Avec le QueryBuilder
		return $this->createQueryBuilder('materiel')
            ->andWhere('materiel.nom like :val')
            ->setParameter('val', "%".$s."%")
            ->orderBy('materiel.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
	}
}
