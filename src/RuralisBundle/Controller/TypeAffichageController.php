<?php

namespace RuralisBundle\Controller;

use RuralisBundle\Entity\TypeAffichage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Typeaffichage controller.
 *
 */
class TypeAffichageController extends Controller
{
    /**
     * Lists all typeAffichage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeAffichages = $em->getRepository('RuralisBundle:TypeAffichage')->findAll();

        return $this->render('typeaffichage/index.html.twig', array(
            'typeAffichages' => $typeAffichages,
        ));
    }

    /**
     * Finds and displays a typeAffichage entity.
     *
     */
    public function showAction(TypeAffichage $typeAffichage)
    {

        return $this->render('typeaffichage/show.html.twig', array(
            'typeAffichage' => $typeAffichage,
        ));
    }
}
