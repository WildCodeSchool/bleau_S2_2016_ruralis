<?php

namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{
    public function sendAction(Request $request)
    {
        $from = $this->getParameter('mailer_user');
        // Instanciation de la variable mail
        $mail = $request->request->get('mail');

        // Stockage du mail dans la table Contact
        $contact = new Contact();
        $form = $this->createForm('RuralisBundle\Form\ContactType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush($contact);

            // Instanciation d'un nouveau message vers l'utilisateur avec la prise en compte des variables
            $message = \Swift_Message::newInstance()
                ->setSubject("Confirmation d'inscription à la newsletter")
                ->setFrom(array($from => 'Ruralis Magazine'))
                ->setTo($mail)
                ->setBody(
                    $this->renderView(
                        '@Ruralis/user/confirmationNewsletter.html.twig',
                        array(
                            'mail' => $mail,
                            /*                            'sujet' => $sujet,
                                                        'message' => $msg*/
                        )
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            // Ajout message sur page d'accueil pour informé de l'enregistrement du mail
            $this->addFlash(
                'notice',
                'Vous êtes maintenant inscrit à la newsletter'
            );

            return $this->redirectToRoute('ruralis_homepage');

        }
        return $this->redirectToRoute('ruralis_homepage');

    }
}