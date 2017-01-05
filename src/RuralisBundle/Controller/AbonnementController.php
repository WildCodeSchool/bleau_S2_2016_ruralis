<?php

namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbonnementController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Ruralis/user/abonnement.html.twig');
    }
}