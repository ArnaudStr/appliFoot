<?php

namespace App\Repository;

use App\Entity\Club;
use App\Entity\Joueur;
use App\Entity\Saison;
use App\Entity\SaisonJoueur;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method SaisonJoueur|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaisonJoueur|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaisonJoueur[]    findAll()
 * @method SaisonJoueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaisonJoueurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaisonJoueur::class);
    }

    /**
     * @return SaisonJoueur[] Renvoie un tableau d'objets SaisonJoueur 
     * qui permettra de récuperer tous les joueurs d'un club pour une saison donnée
     * avec toutes les infos correspondantes (numérot de maillot et nombre de buts inscrits)
     */
    public function findByClubSaison(Club $club, Saison $saison)
    {
        return $this->createQueryBuilder('s')
            ->where('s.club = :club')
            ->andWhere('s.saison = :saison')
            ->setParameter('club', $club)
            ->setParameter('saison', $saison)
            ->orderBy('s.numeroMaillot', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
     /**
     * @return SaisonJoueur[] Renvoie un tableau d'objets SaisonJoueur 
     * qui permettra de récuperer tous les clubs d'un joueur pour une saison donnée
     * avec toutes les infos correspondantes (numérot de maillot et nombre de buts inscrits)
     */
    public function findByJoueurSaison(Joueur $joueur, Saison $saison)
    {
        return $this->createQueryBuilder('s')
            ->where('s.joueur = :joueur')
            ->andWhere('s.saison = :saison')
            ->setParameter('joueur', $joueur)
            ->setParameter('saison', $saison)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?SaisonJoueur
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
