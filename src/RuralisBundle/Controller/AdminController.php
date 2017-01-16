<?php

namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function adminAction()
    {
        return $this->render('@Ruralis/admin/accueilAdmin.html.twig');
    }
}