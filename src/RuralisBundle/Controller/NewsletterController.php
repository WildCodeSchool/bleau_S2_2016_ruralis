<?php

namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Contact;
use RuralisBundle\Entity\Newsletter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Newsletter controller.
 *
 */
class NewsletterController extends Controller
{
    /**
     * Lists all newsletter entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $newsletters = $em->getRepository('RuralisBundle:Newsletter')->findAll();

        return $this->render('@Ruralis/admin/newsletter/index.html.twig', array(
            'newsletters' => $newsletters,
        ));
    }

    /**
     * Creates a new newsletter entity.
     *
     */
    public function newAction(Request $request)
    {
        $newsletter = new Newsletter();
        $form = $this->createForm('RuralisBundle\Form\NewsletterType', $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush($newsletter);

            return $this->redirectToRoute('newsletter_show', array('id' => $newsletter->getId()));
        }

        return $this->render('@Ruralis/admin/newsletter/new.html.twig', array(
            'newsletter' => $newsletter,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a newsletter entity.
     *
     */
    public function showAction(Newsletter $newsletter)
    {
        $deleteForm = $this->createDeleteForm($newsletter);

        return $this->render('@Ruralis/admin/newsletter/show.html.twig', array(
            'newsletter' => $newsletter,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing newsletter entity.
     *
     */
    public function editAction(Request $request, Newsletter $newsletter)
    {
        $deleteForm = $this->createDeleteForm($newsletter);
        $editForm = $this->createForm('RuralisBundle\Form\NewsletterType', $newsletter);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newsletter_edit', array('id' => $newsletter->getId()));
        }

        return $this->render('@Ruralis/admin/newsletter/edit.html.twig', array(
            'newsletter' => $newsletter,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a newsletter entity.
     *
     */
    public function deleteAction(Request $request, Newsletter $newsletter)
    {
        $form = $this->createDeleteForm($newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($newsletter);
            $em->flush($newsletter);
        }

        return $this->redirectToRoute('newsletter_index');
    }

    /**
     * Creates a form to delete a newsletter entity.
     *
     * @param Newsletter $newsletter The newsletter entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Newsletter $newsletter)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('newsletter_delete', array('id' => $newsletter->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function sendAction($id, Newsletter $newsletters)
    {
        $em = $this->getDoctrine()->getManager();
        $abonnesNl = $em->getRepository('RuralisBundle:Abonnement')->findByNewsletter(true);
        $mailAboNl = $em->getRepository('RuralisBundle:Abonnement')->ContactAboNewsletter();
        $newsletter = $em->getRepository('RuralisBundle:Newsletter')->findOneById($id);


        //Structure du mail à enovyer
        $from = $this->getParameter('mailer_user');

        // Instanciation des variables mail, titre, contenu pour récupérer la data
/*        $email = $mailAboNl;*/

        $emails=[];

        foreach ($mailAboNl as $value) {
            $emails[] = $value['email'];
        }
        $titre = $newsletter->getTitre();
        $contenu = $newsletter->getContenu();
        $envoi = $newsletter->setEnvoi(true);
        $em->persist($envoi);
        $em->flush();


        $message = \Swift_Message::newInstance();
        $cid = $message->embed(\Swift_Image::fromPath('/var/www/html/bleau_S2_2016_ruralis/web/bundles/ruralis/images/Logo_Ruralis.png'));
        $message
            ->setSubject($titre)
            ->setFrom(array($from => 'Ruralis Magazine'))
            ->setBcc($emails)
            ->setBody(
                $this->renderView(
                    '@Ruralis/user/newsletter.html.twig',
                    array(
                        'titre' => $titre,
                        'cid' => $cid,
                        'contenu' => $contenu,
                    )
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);

        //Renvoie vers la vue index, avec "newsletter envoyée cochée"
        return $this->redirectToRoute('newsletter_index', array(
            'newsletters' => $newsletters
            ));
    }
}
