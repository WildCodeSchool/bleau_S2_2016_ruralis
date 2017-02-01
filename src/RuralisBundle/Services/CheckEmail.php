<?php

namespace RuralisBundle\Services;

use Doctrine\ORM\EntityManager;
use RuralisBundle\Entity\Abonnement;
use RuralisBundle\Entity\Contact;
use Symfony\Component\DependencyInjection\Container;

class CheckEmail {

    private $container;
    private $em;

    public function __construct(EntityManager $em, Container $container) {
        $this->em = $em;
        $this->container = $container;
    }

    public function checkEmail($email, $newsletter, $type, $newsByNav){
        $alert = null;
        $oldAbo = false;
        /*
         * Type d'erreur:
         * alert = 1 ==> New abonnement mais déja inscrit à la news
         * alert = 2 ==> Essai de se rébonner
         * alert = 3 ==> Newsletter = true
        */

        //Vérifier si l'email existe déjà dans une table Contact
        $contact = $this->em->getRepository('RuralisBundle:Contact')->findOneByEmail($email);
        if ($contact == null) {

            $contact = new Contact();
            $abonnement = new Abonnement();
            $abonnement->setContact($contact);
            $abonnement->getContact()->setEmail($email);

            if ($newsletter == 'on') {
                $abonnement->setNewsletter(true);

                //typeabo
                if ($type == false){
                    $this->setFlash('notice', 'Vous êtes maintenant inscrit à la newsletter');
                }
            }
            else {
                $abonnement->setNewsletter(false);
            }
        }
        // Si le mail existe dans la table
        else {
            $abonnement = $this->em->getRepository('RuralisBundle:Abonnement')->findOneByContact($contact);
//            TODO: a remplacer par le status de l'abonnement (expriré ou en cours)
            if ($abonnement->getStatus() == true && $newsByNav == false){
                $alert = 2;
            }
            else if ($type == false){
                if ($abonnement->getNewsletter() == 1 && $newsletter == 'on'){
                    $this->setFlash('notice', 'Vous êtes déja abonné à la Newsletter');
                }
                if ($abonnement->getNewsletter() == 0 && $newsletter == 'on') {
                    $abonnement->setNewsletter(true);
                    $this->setFlash('notice', 'Vous êtes maintenant inscrit à la Newsletter');
                }
            }
            else{
                $oldAbo = true;
                if ($abonnement->getNewsletter() == 1 && $newsletter == 'on'){
                    $alert = 1;
                }
                if ($abonnement->getNewsletter() == 0 && $newsletter == 'on') {
                    $alert = 3;
                }
            }
        }

        return array(
            'abonnement' => $abonnement,
            'alert' => $alert,
            'contact' => $contact,
            'oldabo' => $oldAbo
        );
    }

    private function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }
}
