<?php

//Theme Name: Ruralis
//Authors: Marielle Lautrou and Aurore David


namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Abonne;
use RuralisBundle\Entity\TypeAbo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{

    /**
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

    /**
     * Private méthode pour créer les abonnements en base si ces derniers n'existent pas
     */
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

    /**
     * Enregistrement d'un nouvel abonné au magazine
     * L'abonné est enregistré que si ses informations ont été validé dans FormulaireControlleur/recapAboAction()
     */
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

    /**
     * Vu renvoyer si le paiement via paypal a échoué
     */
    public function aboannulAction()
    {
        $session = $this->get('request')->getSession();
        $details = $session->get('details');

        return $this->render('@Ruralis/user/annulationAbonnement.html.twig', array(
            'details' => $details,
        ));
    }

    /**
     * Formulaire de desinscription à la Newsletter
     */
    public function desinscriptionNewsAction() {
        return $this->render('@Ruralis/user/desinscriptionNewsletter.html.twig');
    }

    /**
     * Confirmation de desinscription à la Newxsletter
     */
    public function confirmDesinscriptionNewsAction() {
        $em = $this->getDoctrine()->getManager();

        $email = $_POST['email'];

        $contact = $em->getRepository('RuralisBundle:Contact')->findOneByEmail($email);

        $abonnement = $em->getRepository('RuralisBundle:Abonnement')->findOneByContact($contact);

        $abonnement->setNewsletter(null);

        $em->persist($abonnement);
        $em->flush();

        return $this->render('@Ruralis/Default/index.html.twig');
    }
}