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

        //Récupération de la route en cours
       // $request = $this->container->get('request');
        $lastUrl = $this->get('request')->headers->get('referer');

        $this->container->get('ruralis.checkemail')->checkEmail($email);
/*        //Vérifier si l'email existe déjà dans une table Contact
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('RuralisBundle:Contact')->findOneByEmail($email);
        if ($contact == null) {
        //S'il n'existe pas
            $newContact = new Contact();
            $newContact->setEmail($email);

            $abonnement = new Abonnement();
            $abonnement->setContact($newContact);
            $abonnement->setNewsletter(true);
            $em->persist($newContact);

            $this->setFlash('notice', 'Vous êtes maintenant inscrit à la newsletter');

        }
        else {
            $abonnement = $em->getRepository('RuralisBundle:Abonnement')->findOneByContact($contact);
            if ($abonnement->getNewsletter() == true) {
                $this->setFlash('notice', 'Vous êtes déjà inscrit à la newsletter');

            }

            //Abonnement déjà dans la base mais pas encore abonné à la newsletter
            else {
                $abonnement->setNewsletter(true);
                $this->setFlash('notice', 'Vous êtes maintenant abonné et inscrit à la newsletter');
            }
        }
        $em->persist($abonnement);
        $em->flush();*/

        return $this->redirect($lastUrl);
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