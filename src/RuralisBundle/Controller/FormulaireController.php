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
}


//
//// store an attribute for reuse during a later user request
//$session->set('foo', 'bar');
//
//// get the attribute set by another controller in another request
//$foobar = $session->get('foobar');
//
//// use a default value if the attribute doesn't exist
//$filters = $session->get('filters', array());