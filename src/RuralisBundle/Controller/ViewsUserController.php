<?php

//Theme Name: Ruralis
//Authors: Marielle Lautrou and Aurore David


namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Article;
use RuralisBundle\Entity\Newsletter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ViewsUserController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT a FROM RuralisBundle:Article a ORDER BY a.date DESC";
        $query = $em->createQuery($dql);

        $article_une = $em->getRepository('RuralisBundle:Article')->findOneByTypeAffichage('Une');
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),
            10)/*limit per page*/;

        return $this->render('@Ruralis/Default/index.html.twig', array(
            'articles' => $pagination,
            'article_une' => $article_une,
        ));
    }

    public function articleAction(Article $article)
    {
        return $this->render('@Ruralis/user/article.html.twig', array(
            'article' => $article,
        ));
    }

    public function partenairesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $partenaires = $em->getRepository('RuralisBundle:Partenaire')->findAll();

        return $this->render('@Ruralis/user/partenaires.html.twig', array(
            'partenaires' => $partenaires,
        ));
    }

    public function abonnementAction()
    {
        return $this->render('@Ruralis/user/abonnement.html.twig', array(
        ));
    }

    public function cadeauAction(){
        $cadeau = true;
        $notice = $this->container->get('session')->getFlashBag()->set(
            'notice', 'Merci de remplir les informations du bénéficiaire'
        );
        return $this->render("@Ruralis/user/formulaireAbonnement.html.twig", array(
            'cadeau' => $cadeau,
            'notice' => $notice
        ));
    }

    public function ruralisAction()
    {
        return $this->render('@RuralisBundle/Resources/views/user/ruralis.html.twig');
    }

    public function templateNewsletterAction(Newsletter $newsletter)
    {
        return $this->render('@Ruralis/user/newsletter.html.twig', array(
            'newsletter' => $newsletter)
        );
    }

}