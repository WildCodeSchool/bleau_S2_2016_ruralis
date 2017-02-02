<?php

//Theme Name: Ruralis
//Authors: Marielle Lautrou and Aurore David


namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Partenaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Partenaire controller.
 *
 */
class PartenaireController extends Controller
{
    /**
     * Lists all partenaire entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $partenaires = $em->getRepository('RuralisBundle:Partenaire')->findAll();

        return $this->render('@Ruralis/admin/partenaire/index.html.twig', array(
            'partenaires' => $partenaires,
        ));
    }

    /**
     * Creates a new partenaire entity.
     *
     */
    public function newAction(Request $request)
    {
        $partenaire = new Partenaire();
        $form = $this->createForm('RuralisBundle\Form\PartenaireType', $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($partenaire);
            $em->flush($partenaire);

            return $this->redirectToRoute('partenaire_show', array('id' => $partenaire->getId()));
        }

        return $this->render('@Ruralis/admin/partenaire/new.html.twig', array(
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a partenaire entity.
     *
     */
    public function showAction(Partenaire $partenaire)
    {
        return $this->render('@Ruralis/admin/partenaire/show.html.twig', array(
            'partenaire' => $partenaire,
        ));
    }

    /**
     * Displays a form to edit an existing partenaire entity.
     *
     */
    public function editAction(Request $request, Partenaire $partenaire)
    {
        $editForm = $this->createForm('RuralisBundle\Form\PartenaireType', $partenaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $partenaire->getImage()->preUpload();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partenaire_show', array('id' => $partenaire->getId()));
        }

        return $this->render('@Ruralis/admin/partenaire/edit.html.twig', array(
            'partenaire' => $partenaire,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a partenaire entity.
     *
     */
    public function deleteAction($id)
    {
//        Si l'$id est définie alors :
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            // Recherche LE PARTENAIRE à supprimer parmi LES PARTENAIRES
            $partenaire= $em->getRepository('RuralisBundle:Partenaire')->findOneById($id);
            // Recherche L'IMAGE DE LE PARTENAIRE visé
            $image = $em->getRepository('RuralisBundle:Image')->findOneById($partenaire->getImage()->getId());
            // Supprime LE PARTENAIRE et SON IMAGE associée
            $em->remove($partenaire);
            $em->remove($image);
            // Envoie la requête à la BDD
            $em->flush();
            return $this->redirectToRoute('partenaire_index');
        } else
            return $this->redirectToRoute('partenaire_index');
    }
}
