<?php

namespace App\DataFixtures;

use App\Entity\Club;
use App\Entity\User;
use App\Entity\Joueur;
use App\Entity\Saison;
use App\Entity\SaisonJoueur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;


class AppFixtures extends Fixture
{

    // Pour l'encodage des mots de passe des utilisateurs générés
    private $encoder;

    // Pour récuperer les informations nécéssaires via les repositories
    private $entityManager;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
    }
    

    /* Simulons une ligue à 10 clubs sur 10 ans où chaque club a 20 joueurs et chaque joueur a 2 clubs
    *  (c'est à dire qu'on crée 10*20/2 = 100 joueurs)
    *  Chaque joueur joue les 10 saisons dans les mêmes clubs
    *  On crée également 10 comptes utilisateurs
    */
    public function load(ObjectManager $manager)
    {
        $anneeDebutSaisons = 2010;
        $nbSaisons = 10;
        $nbClubs = 10;
        $nbJoueurs = 100;

        $nbUsers=10;

        // Creation Saisons
        for ($i = 0; $i < $nbSaisons; $i++) {
            $saison = new Saison();
            $saison->setAnneeDebut($anneeDebutSaisons+$i);
            $saison->setAnneeFin($anneeDebutSaisons+$i+1);
            $manager->persist($saison);
        }

        // Creation Clubs
        for ($i = 1; $i <= $nbClubs; $i++) {
            $club = new Club();
            $club->setNom('club '.$i);
            $manager->persist($club);
        }

        // Creation Joueurs
        for ($i = 1; $i <= $nbJoueurs; $i++) {
            $joueur = new Joueur();
            $joueur->setNom('Joueur ');
            $joueur->setPrenom(''.$i);
            $manager->persist($joueur);
        }

        // Création des comptes utilisateurs avec encodage du mot de passe
        for ($i = 1; $i <= $nbUsers; $i++) {
            $user = new User();
            $user->setUsername('user'.$i);
        
            $password = $this->encoder->encodePassword($user, 'AllezRacing!');
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
        
            $manager->persist($user);
        }

        // On envoie tout ça à la base de données
        $manager->flush();

        // On va à présent créer les objets saisonJoueur afin d'attribuer des clubs au joueur ainsi que leur statisque
        // pour chaque club et chaque saisons
        // On parcours chaque saisons
        for ($i=0; $i<$nbSaisons; $i++){

            // On reprend le compteur des joueurs à 1, puisqu'on reprend les mêmes joueurs pour chaque saisons
            $indiceJoueur = 1;

            // On récupère la saison
            $saison = $this->entityManager->getRepository(Saison::class)->findOneBy(['anneeDebut' => $anneeDebutSaisons+$i]);
            
            // On parcours chaque club
            for ($j=1; $j<=$nbClubs; $j++){
                // 1er club dans lequel on va inscrire les joueurs
                $club1 = $this->entityManager->getRepository(Club::class)->findOneBy(['nom' => 'club '.$j]);
                
                // 2eme club (Les 10 premiers joueurs du club 1 jouent aussi dans le 2,
                // ceux du club 2 dans le club 3, etc... et ceux du club 10 dans le club 1 pour ne pas avoir de club duppliqués
                if ($j == 10) 
                    $club2 = $this->entityManager->getRepository(Club::class)->findOneBy(['nom' => 'club 1']);
                else $club2 = $this->entityManager->getRepository(Club::class)->findOneBy(['nom' => 'club '.($j+1)]);

                // On inscrit les joueurs dans les 2 clubs
                for ($k=1; $k<=$nbClubs; $k++){
                 
                    // On recupère le joueurs en fonction de son indice
                    $joueur = $this->entityManager->getRepository(Joueur::class)->findOneBy(['prenom' => $indiceJoueur]);
                    $saisonJoueur = new SaisonJoueur();
                    $saisonJoueur->setJoueur($joueur);
                    $saisonJoueur->setSaison($saison);
                    // On inscrit le joueur dans son 1er club
                    $saisonJoueur->setClub($club1);
                    // Le joueur aura un numero de maillot entre 1 et 10
                    $saisonJoueur->setNumeroMaillot($k);
                    // Un joueur marque aléatoirement entre 0 et 20 buts par saison par club
                    $saisonJoueur->setNbButs(rand(0,20));
                    $manager->persist($saisonJoueur);

                    // $club2 = $this->entityManager->getRepository(Club::class)->findOneBy(['nom' => 'club '.(]);
                    $saisonJoueur = new SaisonJoueur();
                    $saisonJoueur->setJoueur($joueur);
                    $saisonJoueur->setSaison($saison);
                    // On inscrit le joueur dans son 2eme club
                    $saisonJoueur->setClub($club2);
                    // On passe au numéro 11 à 20 pour l'inscription dans le 2eme club
                    $saisonJoueur->setNumeroMaillot($k+$nbClubs);
                    $saisonJoueur->setNbButs(rand(0,20));
                    $manager->persist($saisonJoueur);
                    
                    // On passe au joueur suivant
                    $indiceJoueur++;
                }
            }
        }

        $manager->flush();
    }
}
