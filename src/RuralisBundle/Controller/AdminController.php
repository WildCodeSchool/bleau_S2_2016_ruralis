<?php

//Theme Name: Ruralis
//Authors: Marielle Lautrou and Aurore David


namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * Renvoie la vue de la page d'accueil
     */
    public function adminAction()
    {
        return $this->render('@Ruralis/admin/accueilAdmin.html.twig');
    }

    /**
     * Renvoie la page pour selectionner
     */
    public function abonnesAction()
    {
        return $this->render('@Ruralis/admin/abonnes.html.twig');
    }

    /**
     * Renvoie les utilisateurs inscrit à la Newsletter
     */
    public function inscritsNewsletterAction()
    {
        $em = $this->getDoctrine()->getManager();
        $inscritsNewsletter = $em->getRepository('RuralisBundle:Abonnement')->findByNewsletter(true);

        return $this->render('@Ruralis/admin/inscritsNewsletter.html.twig', array(
            'inscritsNewsletter' => $inscritsNewsletter,
            )
        );
    }

    /**
     * Renvoie les utilisateurs inscrit aux magazine
     */
    public function inscritsMagazineAction()
    {
        $em = $this->getDoctrine()->getManager();
        $inscritsMagazine = $em->getRepository('RuralisBundle:Abonnement')->findAll();

        return $this->render('@Ruralis/admin/inscritsMagazine.html.twig', array(
                'inscritsMagazine' => $inscritsMagazine,
            )
        );
    }
}