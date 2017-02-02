<?php

//Theme Name: Ruralis
//Authors: Marielle Lautrou and Aurore David


namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Abonne;
use RuralisBundle\Entity\Contact;
use RuralisBundle\Entity\Abonnement;
use RuralisBundle\Entity\TypeAbo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{

    /*
     * Inscription à la newsletter via le formulaire de la navigation
     */
    public function inscriptionAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Récupération de l'email saisi dans la barre de navigation
        $email = $_POST['email'];

        //Récupération de la route en cours
        $lastUrl = $this->get('request')->headers->get('referer');
        $newsletter = "on";
        $type = false;
        $newsByNav = true;
        //Appel du service CheckEmail
        $abonnement = $this->container->get('ruralis.checkemail')->checkEmail($email, $newsletter, $type, $newsByNav);

        $em->persist($abonnement['abonnement']);
        $em->flush();

        //Affiche l'URL depuis laquelle on s'est inscrit à la newsletter
        return $this->redirect($lastUrl);
    }

    private function createAbo($em)
    {
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

        return ;
    }

    public function abosendAction()
    {
        $em = $this->getDoctrine()->getManager();
        $typeAbo = $em->getRepository('RuralisBundle:TypeAbo')->findAll();

        if(empty($typeAbo)){
            $this->createAbo($em);
        }

        $session = $this->get('request')->getSession();
        $details = $session->get('details');

        $prenom =  $details['prenom'];
        $nom =  $details['nom'];
        $tel =  $details['tel'];
        $rue =  $details['rue'];
        $cp =  $details['cp'];
        $ville =  $details['ville'];
        $pays =  $details['pays'];
        $contact = $details['contact'];
        $abonnement = $details['abonnement'];

        if ($details['oldabo'] == true){
            $abonnement = $em->getRepository('RuralisBundle:Abonnement')->findOneByContact($contact);
        }

        if ($details['alert'] == 3){
            $abonnement->setNewsletter(true);
        }
        else{
            $abonnement->setNewsletter(false);
        }

        //Je créé un nouvel abonné avec les infos de $details
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
        $abonnement->setStatus(true);

        $em->persist($abonnement);
        $em->flush();

        $session->remove('details');
        // Si abonnement et paiement validé sur Paypal vue "validation"

        return $this->render('@Ruralis/user/validationAbonnement.html.twig', array(
            'details' => $details,
        ));
    }

    public function aboannulAction()
    {
        $session = $this->get('request')->getSession();
        $details = $session->get('details');

        // Si echec d'abonnement via Paypal : renvoie la vue "annulation"
        return $this->render('@Ruralis/user/annulationAbonnement.html.twig', array(
            'details' => $details,
        ));
    }

    //Quand un abonné souhaite se désinscrire de la newsletter renvoyé vers cette page pour saisir son adresse
    public function desinscriptionNewsAction() {
        return $this->render('@Ruralis/user/desinscriptionNewsletter.html.twig');
    }

    public function confirmDesinscriptionNewsAction() {
        $em = $this->getDoctrine()->getManager();

        $email = $_POST['email'];

        $contact = $em->getRepository('RuralisBundle:Contact')->findOneByEmail($email);

        $abonnement = $em->getRepository('RuralisBundle:Abonnement')->findOneByContact($contact);
        $abonnement->getContact()->getEmail();

        $abonnement->setNewsletter(null);

        $em->persist($abonnement);
        $em->flush();

        return $this->render('@Ruralis/Default/index.html.twig');

    }
}