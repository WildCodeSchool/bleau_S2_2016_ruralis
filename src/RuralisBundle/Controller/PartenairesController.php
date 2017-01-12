<?php

namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PartenairesController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $partenaires = $em->getRepository('RuralisBundle:Partenaire')->findAll();

        return $this->render('@Ruralis/user/partenaires.html.twig', array(
            'partenaires' => $partenaires,
        ));
    }


}
