<?php

namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RuralisBundle\Form\ArticleType;
/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('RuralisBundle:Article')->findAll();
        return $this->render('@Ruralis/admin/article/index.html.twig', array(
            'articles' => $articles,
        ));
    }
    /**
     * Creates a new article entity.
     *
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm('RuralisBundle\Form\ArticleType', $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('article_show', array('id' => $article->getId())
            );
        }
        return $this->render('@Ruralis/admin/article/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }
    /**
     * Finds and displays a article entity.
     *
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('@Ruralis/admin/article/show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     */
    public function editAction(Request $request, Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('RuralisBundle:Image')->findOneById($article->getImage()->getId());
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('RuralisBundle\Form\ArticleType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $image->preUpload();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('article_show', array('id' => $article->getId()));
        }
        return $this->render('@Ruralis/admin/article/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Article entity.
     *
     */
    public function deleteAction($id)
    {
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            // Recherche L'ARTICLE à supprimer parmi LES ARTICLES
            $article = $em->getRepository('RuralisBundle:Article')->findOneById($id);
            // Recherche L'IMAGE DE L'ARTICLE visé
            $image = $em->getRepository('RuralisBundle:Image')->findOneById($article->getImage()->getId());
            // Supprime L'ARTICLE et SON IMAGE associée
            $em->remove($article);
            $em->remove($image);
            // Envoie la requête à la BDD
            $em->flush();
            return $this->redirectToRoute('article_index');
        } else
            return $this->redirectToRoute('article_index');
    }
    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */

    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
