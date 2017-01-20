<?php

namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Abonne;
use RuralisBundle\Entity\TypeAbo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{
    public function inscriptionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //Récupération de l'email saisi dans la barre de navigation
        $email = $_POST['email'];

        //Récupération de la route en cours
        $lastUrl = $this->get('request')->headers->get('referer');

        //Appel du service CheckEmail
        $abonnement = $this->container->get('ruralis.checkemail')->checkEmail($email);
/*        if ($abonnement == 400) {

            return $this->render('@Ruralis/admin/accueilAdmin.html.twig');
        }*/
        
/*        else {*/
            $em->persist($abonnement);
            $em->flush();
        /*}*/


        //Affiche l'URL depuis laquelle on s'est inscrit à la newsletter
        return $this->redirect($lastUrl);
    }

    public function abosendAction()
    {
        $em = $this->getDoctrine()->getManager();
        $typeAbo = $em->getRepository('RuralisBundle:TypeAbo')->findAll();

        $session = $this->get('request')->getSession();
        $details = $session->get('details');

        $prenom =  $details['prenom'];
        $nom =  $details['nom'];
        $email = $details['email'];
        $tel =  $details['tel'];
        $rue =  $details['rue'];
        $cp =  $details['cp'];
        $ville =  $details['ville'];
        $pays =  $details['pays'];

        if (empty($typeAbo)){
            $lecteur = new TypeAbo();
            $donateur = new TypeAbo();
            $ambassadeur = new TypeAbo();

            $lecteur->setType('lecteur');
            $donateur->setType('donateur');
            $ambassadeur->setType('ambassadeur');

            $em->persist($lecteur);
            $em->persist($donateur);
            $em->persist($ambassadeur);

            $em->flush();
        }

        //Appel du service CheckEmail
        $abonnement = $this->container->get('ruralis.checkemail')->checkEmail($email);

/*        if ($abonnement == 400){
            return $this->render('@Ruralis/admin/accueilAdmin.html.twig');
        }*/

/*        else {*/
            //Je créé un nouvel abonne avec les infos de $details
            $newAbonne = new Abonne();
            $newAbonne->setNom($nom);
            $newAbonne->setPrenom($prenom);
            $newAbonne->setRue($rue);
            $newAbonne->setTelephone($tel);
            $newAbonne->setCp($cp);
            $newAbonne->setVille($ville);
            $newAbonne->setPays($pays);
            //Je récupère la date d'abonnement
            $newAbonne->setDateAbonnement(new \DateTime());

            //Je créé un nouveau TypeAbo avec les données de $type
            $type = $session->get('type');
            $newTypeAbo = $em->getRepository('RuralisBundle:TypeAbo')->findOneByType($type);

            $abonnement->setAbonne($newAbonne);
            $abonnement->setTypeAbo($newTypeAbo);

            $em->persist($abonnement);
            $em->flush();

            //Lien vers l'API

            return $this->render('@Ruralis/admin/accueilAdmin.html.twig', array(
                'details' => $details,
            ));
/*        }*/
    }
}