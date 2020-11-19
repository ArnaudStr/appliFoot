<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Joueur;
use App\Entity\Saison;
use App\Entity\SaisonJoueur;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * On vérifie que l'utilisateur est bien connecté pour pouvoir accéder à l'appli
 * Il est redirigé vers la page de connexion si il n'est pas connecté
 * @IsGranted("ROLE_USER")
 */
class AppController extends AbstractController
{
    /**
     * @Route("/listeClubs", name="listeClubs")
     * Affichage de la liste des clubs avec sélecteur de saison
     */
    public function listeClubs() {
        // On récupère tous les clubs et toutes les saisons (pour le sélécteur)
        $allClubs = $this->getDoctrine()->getRepository(Club::class)->findAll();
        $allSaisons = $this->getDoctrine()->getRepository(Saison::class)->findAll();

        // Appel à la vue
        return $this->render('app/listeClubs.html.twig', [
            'title' => 'Liste des clubs',
            'clubs' => $allClubs,
            'saisons' => $allSaisons,
        ]);
    }

    // Fonction pour calculer le nombre total de buts inscrits par un club (ou un joueur) pour une saison donnée
    public function totalButsClub($saisonJoueurs) {
        $totalButs = 0;
        foreach($saisonJoueurs as $saisonJoueur){
            $totalButs+=$saisonJoueur->getNbButs();
        }

        return $totalButs;
    }

    /**
     * @Route("/clubSaison/{idClub}/{idSaison}", name="clubSaison")
     * @ParamConverter("club", options={"id" = "idClub"})
     * @ParamConverter("saison", options={"id" = "idSaison"})
     * Affichage de la liste des joueurs du club pour la saison courante
     */
    public function clubSaison(Club $club, Saison $saison) {

        $allSaisons = $this->getDoctrine()->getRepository(Saison::class)->findAll();

        // Récupération des joueurs et de leur statistiques au club pour la saison courante
        $saisonJoueurs = $this->getDoctrine()->getRepository(SaisonJoueur::class)->findByClubSaison($club, $saison);

        return $this->render('app/club.html.twig', [
            'title' => $club.' '.$saison,
            'club' => $club,
            'saison' => $saison,
            'saisonJoueurs' => $saisonJoueurs,
            'saisons' => $allSaisons,
            'totalButs' => $this->totalButsClub($saisonJoueurs)
        ]);
    }

    /**
     * @Route("/infoJoueur/{idJoueur}/{idSaison}", name="infoJoueur")
     * @ParamConverter("joueur", options={"id" = "idJoueur"})
     * @ParamConverter("saison", options={"id" = "idSaison"})
     * Liste des clubs d'un joueur pour la saison courante, ainsi que les statistiques associées
     */
    public function infoJoueur(Joueur $joueur, Saison $saison) {

        $saisonJoueurs = $this->getDoctrine()->getRepository(SaisonJoueur::class)->findByJoueurSaison($joueur, $saison);
        $allSaisons = $this->getDoctrine()->getRepository(Saison::class)->findAll();

        return $this->render('app/joueur.html.twig', [
            'title' => $joueur.' '.$saison,
            'joueur' => $joueur,
            'saison' => $saison,
            'saisonJoueurs' => $saisonJoueurs,
            'saisons' => $allSaisons,
            'totalButs' => $this->totalButsClub($saisonJoueurs)
        ]);
    }
}
