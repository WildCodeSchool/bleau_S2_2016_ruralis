<?php

//Theme Name: Ruralis
//Authors: Marielle Lautrou and Aurore David


namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ViewsUserController extends Controller
{
    /**
     * Liste tous les articles du blog
    */
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

    /**
     * Liste un article
     */
    public function articleAction(Article $article)
    {
        return $this->render('@Ruralis/user/article.html.twig', array(
            'article' => $article,
        ));
    }

    /**
     * Liste tous les partenaires
     */
    public function partenairesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $partenaires = $em->getRepository('RuralisBundle:Partenaire')->findAll();

        return $this->render('@Ruralis/user/partenaires.html.twig', array(
            'partenaires' => $partenaires,
        ));
    }

    /**
     * Vue pour s'abonner au magazine
     */
    public function abonnementAction()
    {
        return $this->render('@Ruralis/user/abonnement.html.twig', array(
        ));
    }

    /**
     * Offrir un abonnement
     */
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

    /**
     * Page de présentation du magazine
     */
    public function ruralisAction()
    {
        return $this->render('@Ruralis/user/ruralis.html.twig');
    }
}