<?php

namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Abonnement;
use RuralisBundle\Entity\Contact;
use RuralisBundle\Entity\TypeAbo;
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
        $email = $_POST['email'];

        //Vérifier si l'email existe déjà dans une table Contact
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('RuralisBundle:Contact')->findOneByEmail($email);
        $plop = $contact->getEmail();
        dump($plop);die();
        //S'il n'existe pas
/*            if ($contact($email) = $email) {
                $contact = new Contact();
                $contact->setEmail($email);
                $abonnement = new Abonnement();
                $abonnement->setContact($contact);
            }*/

        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();




        return $this->render('@Ruralis/admin/accueilAdmin.html.twig', array(
            'contact' => $contact,
        ));
    }
/*
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
                     /*   )
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            // Ajout message sur page d'accueil pour informé de l'enregistrement du mail
            $this->addFlash(
                'notice',
                'Vous êtes maintenant inscrit à la newsletter'
            );*/

/*            return $this->redirectToRoute('ruralis_homepage');*/
/*
        }
        return $this->redirectToRoute('ruralis_homepage');*/

/*    } */
}