<?php

namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT a FROM RuralisBundle:Article a ORDER BY a.date DESC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),
            10)/*limit per page*/;

        return $this->render('RuralisBundle:Default:index.html.twig', array(
            'articles' => $pagination,
        ));
    }

    public function articleAction(Article $article)
    {
        return $this->render('@Ruralis/user/article.html.twig', array(
            'article' => $article,
        ));
    }
}