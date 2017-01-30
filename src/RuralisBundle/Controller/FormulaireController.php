<?php

namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class FormulaireController extends Controller
{
    const ABO_LECTEUR = 'lecteur(trice)';
    const ABO_DONATEUR = 'donateur(trice)';
    const ABO_AMBASSADEUR = 'ambassadeur(drice)';

    public function indexAction(Request $request, $type)
    {
        $session = $this->get('request')->getSession();
        $session->set('type', $type);

        $type = $session->get('type');

        return $this->render('@Ruralis/user/formulaireAbonnement.html.twig', array(
            'type' => $type,
        ));
    }

    public function recapAboAction(Request $request)
    {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $rue = $_POST['rue'];
        $cp = $_POST['cp'];
        $ville = $_POST['ville'];
        $pays = $_POST['pays'];

//        Si Newsletter est cochée $newsletter='on'
        if (isset($_POST['newsletter'])) {
            $newsletter = "on";
        }
        else {
            $newsletter = 'off';
        }

        $session = $this->get('request')->getSession();
        $session->set('details', array(

            'prenom' => $prenom,
            'nom' => $nom,
            'email' => $email,
            'tel' => $tel,
            'rue' => $rue,
            'cp' => $cp,
            'ville' => $ville,
            'pays' => $pays,
            'newsletter' => $newsletter,
        ));

        $details = $session->get('details');

        //Lien vers l'API
        return $this->render('@Ruralis/user/recapitulatifAbo.html.twig', array(
            'details' => $details,
        ));
    }
}