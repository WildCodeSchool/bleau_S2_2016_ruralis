<?php

namespace RuralisBundle\Controller;

use Doctrine\ORM\EntityManager;
use RuralisBundle\Entity\Abonne;
use RuralisBundle\Entity\Abonnement;
use RuralisBundle\Entity\Contact;
use RuralisBundle\Entity\TypeAbo;
use RuralisBundle\Repository\AbonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{
    public function sendAction(Request $request)
    {
        //Récupération de l'email saisi dans la barre de navigation
        $email = $_POST['email'];

        //Récupération de la route en cours
        $lastUrl = $this->get('request')->headers->get('referer');

        //Appel du service CheckEmail
        $this->container->get('ruralis.checkemail')->checkEmail($email);

        //Affiche l'URL depuis laquelle on s'est inscrit à la newsletter
        return $this->redirect($lastUrl);
    }


//    CODE AURORE


    public function abosendAction(Request $request, $details)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('request')->getSession();
        $details = $this->get('session')->get('details');

        $prenom =  $details['prenom'];
        $nom =  $details['nom'];
        $email = $details['email'];
        $tel =  $details['tel'];
        $rue =  $details['rue'];
        $cp =  $details['cp'];
        $ville =  $details['ville'];
        $pays =  $details['pays'];

//        //Appel du service CheckEmail
//        $this->container->get('ruralis.checkemail')->checkEmail($email);

        $session->set('details', array(

            'prenom' => $prenom,
            'nom' => $nom,
            'email' => $email,
            'tel' => $tel,
            'rue' => $rue,
            'cp' => $cp,
            'ville' => $ville,
            'pays' => $pays,
        ));

        $details = $session->get('details');

        //Vérifie si l'email existe déjà dans une table Contact
        $contact = $em->getRepository('RuralisBundle:Contact')->findOneByEmail($email);

        //Vérifie si l'abonne existe déjà dans une table abonnement
//        $abonne = $em->getRepository('RuralisBundle:Abonne')->findOneBy($);

        if ($contact == null) {
            //S'il n'existe pas je créer un contact
            $newContact = new Contact();
            $newContact->setEmail($email);

            $em->persist($newContact);

            //Je créé un nouvel abonne avec les info de $details
            $newAbonne = new Abonne();
            $newAbonne->setNom($nom);
            $newAbonne->setPrenom($prenom);
            $newAbonne->setRue($rue);
            $newAbonne->setTelephone($tel);
            $newAbonne->setCp($cp);
            $newAbonne->setVille($ville);
            $newAbonne->setPays($pays);

            $em->persist($newContact);

            //Je créé un nouveAu TypeAbo avec les donnés de $type
            $newTypeAbo = new TypeAbo();
            $type = $session->get('type');
            $newTypeAbo->setType($type);

            $em->persist($newTypeAbo);

            // Je récupère les nouveaux objets contact, abonne et typeAbo
            $newAbonnement = new Abonnement();
            $newAbonnement->setContact($newContact);
            $newAbonnement->setAbonne($newAbonne);
            $newAbonnement->setTypeAbo($newTypeAbo);
            $newAbonnement->setNewsletter(true);

            $em->persist($newAbonnement);

            dump($newAbonnement);
            die();


//            $this->setFlash('notice', 'Vous êtes maintenant inscrit à la newsletter');
        }
       
            //        else {
//            $abonnement = $this->em->getRepository('RuralisBundle:Abonnement')->findOneByContact($contact);
//            if ($abonnement->getNewsletter() == true) {
//                $this->setFlash('notice', 'Vous êtes déjà inscrit à la newsletter');
//
//            }
//
//            //Abonnement déjà dans la base mais pas encore abonné à la newsletter
//            else {
//                $abonnement->setNewsletter(true);
//                $this->setFlash('notice', 'Vous êtes maintenant abonné et inscrit à la newsletter');
//            }
//        }
//        $em->persist($abonnement);
//        $em->flush();
//
//        dump($details); die();




        //Lien vers l'API

        return $this->render('@Ruralis/admin/accueilAdmin.html.twig', array(
            'details' => $details,
        ));
    }
}