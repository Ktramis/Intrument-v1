<?php

namespace App\Repository;

use App\Repository\emply;
use App\Entity\Produit;
use App\Classe\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function add(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findWithSearch(Search $search){
        $query = $this
        //je cree ma requette a l'aide de la table produit
        ->createQueryBuilder('p')
        // on selection la table ptoduit et la table categorie
        ->select('c','p')

        //on join la categorie a la table produit
        ->join('p.Categorie','c');

        if (!empty($search->categorie)){
            $query =$query
             //si l'uttilisateur renseigne une categorie 
            //tu rajoute le parametre categorie
            ->andWhere('c.id In (:categorie)')
            ->setParameter('categorie',$search->categorie);
            //je te donne le parametre categorie qui aura la valleur qui est dans $search
        }

        if(!empty($search->string)){
            $query = $query

            ->andWhere('p.name LIKE :string')
            ->setParameter('string',"%$search->string%");
        }
        //creation de la requette et retoure du resultat
        return $query->getQuery()->getResult();
    }





//    /**
//     * @return Produit[] Returns an array of Produit objects
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

//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
