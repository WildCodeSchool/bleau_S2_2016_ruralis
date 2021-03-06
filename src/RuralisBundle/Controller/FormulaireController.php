<?php

//Theme Name: Ruralis
//Authors: Marielle Lautrou and Aurore David


namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FormulaireController extends Controller
{
    /**
     * Affichage du fomulaire d'abonnement en fonction du type d'abonnement choisi
    */
    public function indexAction($type)
    {
        $session = $this->get('request')->getSession();
        $session->set('type', $type);

        $type = $session->get('type');

        return $this->render('@Ruralis/user/formulaireAbonnement.html.twig', array(
            'type' => $type,
        ));
    }

    /**
     * Récapitulatif des informations saisi par l'utilisateur + validation de son adresse mail (déja enregistré ou non)
    */
    public function recapAboAction()
    {
        $newsByNav = false;

        $session = $this->get('request')->getSession();

        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $rue = $_POST['rue'];
        $cp = $_POST['cp'];
        $ville = $_POST['ville'];
        $pays = $_POST['pays'];
        $type = $session->get('type');

//        Si Newsletter est cochée $newsletter='on'
        if (isset($_POST['newsletter'])) {
            $newsletter = "on";
        }
        else {
            $newsletter = 'off';
        }


        //Appel du service CheckEmail
        $abonnement = $this->container->get('ruralis.checkemail')->checkEmail($email, $newsletter, $type, $newsByNav);

        if ($abonnement['alert'] == 2){
            $this->container->get('session')->getFlashBag()->set(
                'notice', 'Vous etes déja abonné au journal pour l\'année en cours'
            );
            return $this->redirectToRoute('ruralis_homepage');
        }

        $session = $this->get('request')->getSession();
        $session->set('details', array(
            'prenom' => $prenom,
            'nom' => $nom,
            'tel' => $tel,
            'rue' => $rue,
            'cp' => $cp,
            'ville' => $ville,
            'pays' => $pays,
            'email' => $email,
            'newsletter' => $newsletter,
            'abonnement' => $abonnement['abonnement'],
            'contact' => $abonnement['contact'],
            'alert' => $abonnement['alert'],
            'oldabo' => $abonnement['oldabo']
        ));

        $details = $session->get('details');
        $cadeau = $session->get('cadeau');

        //Lien vers l'API
        return $this->render('@Ruralis/user/recapitulatifAbo.html.twig', array(
            'details' => $details,
            'alert' => $abonnement['alert'],
            'type' => $type,
            'cadeau' => $cadeau
        ));
    }
}