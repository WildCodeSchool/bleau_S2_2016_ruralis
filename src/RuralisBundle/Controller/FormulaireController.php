<?php

namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class FormulaireController extends Controller
{
    const ABO_LECTEUR = 'lecteur';
    const ABO_DONATEUR = 'donateur';
    const ABO_AMBASSADEUR = 'ambassadeur';

    public function indexAction(Request $request, $type)
    {
        $session = $this->get('request')->getSession();
        $session->set('type', $type);

//        $infoUser = array(
//            'typeAbo' => $type,
//        );

        $type = $session->get('type');

        return $this->render('@Ruralis/user/formulaireAbonnement.html.twig', array(
            'type' => $type,
        ));
    }

    public function recapAboAction(Request $request, $details)
    {
        $session = $this->get('request')->getSession();
        $session->set('details', array(
            'typeAbo' => $type,
            'prenom' => $prenom,
            'nom' => $nom,
            'email' => $email,
            'tel' => $tel,
            'rue' => $rue,
            'cp' => $cp,
            'ville' => $ville,
        ));

        $details = $session->get('details');

        if ($formAbo->isSubmitted() && $formAbo->isValid()) {
            return $this->redirectToRoute('ruralis_recapitulatif_abo', array(
                'details' => $details));
        }
        return $this->render('@Ruralis/user/formulaireAbonnement.html.twig', array(
            'details' => $details,
        ));
    }
}