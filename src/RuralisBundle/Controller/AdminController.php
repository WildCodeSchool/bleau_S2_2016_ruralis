<?php

namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function adminAction()
    {
        return $this->render('@Ruralis/admin/accueilAdmin.html.twig');
    }

    public function inscritsNewsletterAction()
    {
        $em = $this->getDoctrine()->getManager();
        $inscritsNewsletter = $em->getRepository('RuralisBundle:Abonnement')->findByNewsletter(true);

        return $this->render('@Ruralis/admin/inscritsNewsletter.html.twig', array(
            'inscritsNewsletter' => $inscritsNewsletter,
            )
        );
    }

    public function abonnesAction()
    {
        return $this->render('@Ruralis/admin/abonnes.html.twig');
    }
}