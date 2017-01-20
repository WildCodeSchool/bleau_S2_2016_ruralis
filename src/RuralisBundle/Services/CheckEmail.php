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
        // Si le mail existe dans la table
        else {
            $abonnement = $this->em->getRepository('RuralisBundle:Abonnement')->findOneByContact($contact);
            // Je vérifie qu'il est déjà dans abonné au journal
            // S'il est déjà abonné renvoie message Flash
            if ($abonnement->getAbonne() != null)
            {
                $this->setFlash('notice', 'Vous êtes déjà abonné à Ruralis Magazine et à la Newsletter');
/*                return $abonnement = 400;*/
            }

            // Si déjà abonné à la newsletter
            elseif ($abonnement->getNewsletter() == true) {
                $this->setFlash('notice', 'Vous étiez déjà inscrit à la newsletter, vous êtes maintenant abonné');
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
