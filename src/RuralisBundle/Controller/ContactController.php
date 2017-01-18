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
        //Récupération de l'email saisi dans la barre de navigation
        $email = $_POST['email'];

        //Récupération de la route en cours
        $lastUrl = $this->get('request')->headers->get('referer');

        //Appel du service CheckEmail
        $this->container->get('ruralis.checkemail')->checkEmail($email);

        //Affiche l'URL depuis laquelle on s'est inscrit à la newsletter
        return $this->redirect($lastUrl);
    }
}