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

    public function checkEmail($email){

        //Vérifier si l'email existe déjà dans une table Contact
        $contact = $this->em->getRepository('RuralisBundle:Contact')->findOneByEmail($email);
        if ($contact == null) {
            //S'il n'existe pas
            $newContact = new Contact();
            $newContact->setEmail($email);

            $abonnement = new Abonnement();
            $abonnement->setContact($newContact);
            $abonnement->setNewsletter(true);
            $this->em->persist($newContact);

            $this->setFlash('notice', 'Vous êtes maintenant inscrit à la newsletter');
        }
        else {
            $abonnement = $this->em->getRepository('RuralisBundle:Abonnement')->findOneByContact($contact);
            //Si Contact existe dans abonnment mais n'est pas abonné au magazine
            if (isset($abonnement->getContact())) {
                $abonnement->setAbonne($newAbonne);
                $abonnement->setTypeAbo($newTypeAbo);
            }
            if ($abonnement->getNewsletter() == true) {
                $this->setFlash('notice', 'Vous êtes déjà inscrit à la newsletter');

            }

            //Abonnement déjà dans la base mais pas encore abonné à la newsletter
            else {
                $abonnement->setNewsletter(true);
                $this->setFlash('notice', 'Vous êtes maintenant abonné et inscrit à la newsletter');
            }
        }

        return $abonnement;
    }

    private function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }
}