<?php

namespace RuralisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FormulaireController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Ruralis/user/formulaireAbonnement.html.twig');
    }
}