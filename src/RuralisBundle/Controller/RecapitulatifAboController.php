<?php

namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class RecapitulatifAboController extends Controller
{
    const ABO_LECTEUR = 'lecteur';
    const ABO_DONATEUR = 'donateur';
    const ABO_AMBASSADEUR = 'ambassadeur';

    public function indexAction(Request $request, $details)
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

//        $details = array(
//            'typeAbo' => $type,
//            'prenom' => $prenom,
//            'nom' => $nom,
//            'email' => $email,
//            'tel' => $tel,
//            'rue' => $rue,
//            'cp' => $cp,
//            'ville' => $ville,
//        );

        $details = $session->get('details');

        return $this->render('@Ruralis/user/recapitulatifAbo.html.twig', array(
            'details' => $details,
        ));
    }



}