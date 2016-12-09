<?php

namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('RuralisBundle:Article')->findAll();
        return $this->render('RuralisBundle:Default:index.html.twig', array(
            'articles' => $articles,
        ));
    }
}
