<?php

namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbonnementController extends Controller
{
    public function indexAction()
    {
        return $this->render('@RuralisBundle/Resources/views/user/abonnement.html.twig');
    }
}