<?php

namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Abonne;
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
        $em = $this->getDoctrine()->getManager();

        //Récupération de l'email saisi dans la barre de navigation
        $email = $_POST['email'];

        //Récupération de la route en cours
        $lastUrl = $this->get('request')->headers->get('referer');

        //Appel du service CheckEmail
        $abonnement = $this->container->get('ruralis.checkemail')->checkEmail($email);

        $em->persist($abonnement);
        $em->flush();
        //Affiche l'URL depuis laquelle on s'est inscrit à la newsletter
        return $this->redirect($lastUrl);
    }


//    CODE AURORE


    public function abosendAction()
    {
        $em = $this->getDoctrine()->getManager();
        $typeAbo = $em->getRepository('RuralisBundle:TypeAbo')->findAll();
        if (empty($typeAbo)){
            $lecteur = new TypeAbo();
            $donateur = new TypeAbo();
            $ambassadeur = new TypeAbo();

            $lecteur->setType('lecteur');
            $donateur->setType('donateur');
            $ambassadeur->setType('ambassadeur');

            $em->persist($lecteur);
            $em->persist($donateur);
            $em->persist($ambassadeur);

            $em->flush();
        }

        $session = $this->get('request')->getSession();
        $details = $session->get('details');

        $prenom =  $details['prenom'];
        $nom =  $details['nom'];
        $email = $details['email'];
        $tel =  $details['tel'];
        $rue =  $details['rue'];
        $cp =  $details['cp'];
        $ville =  $details['ville'];
        $pays =  $details['pays'];

        //Vérifie si l'abonne existe déjà dans une table abonnement
//        $abonne = $em->getRepository('RuralisBundle:Abonne')->findOneBy($???);

        //Appel du service CheckEmail
        $abonnement = $this->container->get('ruralis.checkemail')->checkEmail($email);

        //Je créé un nouvel abonne avec les infos de $details
        $newAbonne = new Abonne();
        $newAbonne->setNom($nom);
        $newAbonne->setPrenom($prenom);
        $newAbonne->setRue($rue);
        $newAbonne->setTelephone($tel);
        $newAbonne->setCp($cp);
        $newAbonne->setVille($ville);
        $newAbonne->setPays($pays);
        //Je récupère la date d'abonnement
        $newAbonne->setDateAbonnement(new \DateTime());

        //Je créé un nouveau TypeAbo avec les données de $type
        $type = $session->get('type');
        $newTypeAbo = $em->getRepository('RuralisBundle:TypeAbo')->findOneByType($type);

        $abonnement->setAbonne($newAbonne);
        $abonnement->setTypeAbo($newTypeAbo);

        $em->persist($abonnement);
        $em->flush();

//        else {
//            //Je créé un nouvel abonne avec les infos de $details
//            $newAbonne = new Abonne();
//            $newAbonne->setNom($nom);
//            $newAbonne->setPrenom($prenom);
//            $newAbonne->setRue($rue);
//            $newAbonne->setTelephone($tel);
//            $newAbonne->setCp($cp);
//            $newAbonne->setVille($ville);
//            $newAbonne->setPays($pays);
//
//            $em->persist($newAbonne);
//
//            //Je créé un nouveAu TypeAbo avec les donnés de $type
//            $newTypeAbo = new TypeAbo();
//            $type = $session->get('type');
//            $newTypeAbo->setType($type);
//
//            $em->persist($newTypeAbo);
//
//            // Je récupère les nouveaux objets abonne et typeAbo et j'injecte contact
//            $newAbonnement = new Abonnement();
//            $newAbonnement->getContact('email');
//            $newAbonnement->setAbonne($newAbonne);
//            $newAbonnement->setTypeAbo($newTypeAbo);
//            $newAbonnement->setNewsletter(true);
//
//            $em->persist($newAbonnement);
//
//            dump($newAbonnement);
//            die();


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