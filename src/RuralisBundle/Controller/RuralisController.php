<?php

namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RuralisController extends Controller
{
    public function indexAction()
    {
        return $this->render('@RuralisBundle/Resources/views/user/ruralis.html.twig');
    }
}