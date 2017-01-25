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

    public function checkEmail($email, $newsletter, $type){

        //Vérifier si l'email existe déjà dans une table Contact
        $contact = $this->em->getRepository('RuralisBundle:Contact')->findOneByEmail($email);
        if ($contact == null) {
            $newContact = new Contact();
            $newContact->setEmail($email);

            $abonnement = new Abonnement();
            $abonnement->setContact($newContact);

            if ($newsletter == 'on') {
                $abonnement->setNewsletter(true);


                //typeabo
                if ($type == false){
                    $this->setFlash('notice', 'Vous êtes maintenant inscrit à la newsletter');
                }
                else{
                    $this->setFlash('notice', 'Vous êtes maintenant inscrit à la newsletter et au journal');
                }
            }
            else {
                $abonnement->setNewsletter(false);
                $this->setFlash('notice', 'Vous êtes maintenant abonné au magazine');
            }

            $this->em->persist($newContact);


        }
        // Si le mail existe dans la table
        else {
            $abonnement = $this->em->getRepository('RuralisBundle:Abonnement')->findOneByContact($contact);
            // Je vérifie qu'il est déjà dans abonné au journal
            // S'il est déjà abonné renvoie message Flash
            if ($abonnement->getAbonne() != null)
            {
                if ($abonnement->getNewsletter() == true)
                {
                    if ($abonnement->getAbonne() != null){
                        $this->setFlash('notice', 'Vous êtes déjà abonné à la Newsletter et au magazine');
                    }
                    else {
                        $this->setFlash('notice', 'Vous étiez déjà abonné à la Newsletter');
                    }
                }
                elseif ($abonnement->getNewsletter() == 'off' && $type != null) {
                    $abonnement->setNewsletter(false);
                    $this->setFlash('notice', 'Vous êtes déjà abonné à Ruralis Magazine mais pas à la newsletter');
                }
                else {
                    $abonnement->setNewsletter(true);
                    $this->setFlash('notice', 'Vous êtes déjà abonné à Ruralis Magazine, vous êtes maintenant inscrit à la newsletter');
                    /*                return $abonnement = 400;*/
                }
            }

            // Si déjà abonné à la newsletter
            elseif ($abonnement->getNewsletter() == true) {
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
