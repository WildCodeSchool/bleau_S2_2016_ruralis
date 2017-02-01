<?php

namespace RuralisBundle\Controller;

use RuralisBundle\Entity\Contact;
use RuralisBundle\Entity\Newsletter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Newsletter controller.
 *
 */
class NewsletterController extends Controller
{
    /**
     * Lists all newsletter entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $newsletters = $em->getRepository('RuralisBundle:Newsletter')->findAll();

        return $this->render('@Ruralis/admin/newsletter/index.html.twig', array(
            'newsletters' => $newsletters,
        ));
    }

    /**
     * Creates a new newsletter entity.
     *
     */
    public function newAction(Request $request)
    {
        $newsletter = new Newsletter();
        $form = $this->createForm('RuralisBundle\Form\NewsletterType', $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

//            On réccupère toutes les balises images et leurs contenus à l'intérieur de contenu de la news et on les stock dans un tableau
            $doc = new \DOMDocument();
            $doc->loadHTML($newsletter->getContenu());
            $imageTags = $doc->getElementsByTagName('img');

//            Parcours de tous les éléments image de notre contenu
            foreach($imageTags as $tag) {
//                Récupération du lien de de l'image sur notre serveur
                $path = __DIR__ . '/../../../..' .  $tag->getAttribute('src');
//                Récupération de l'extension du fichier
                $type = pathinfo($path, PATHINFO_EXTENSION);
//                Récupération de l'image au "format txt"
                $data = file_get_contents($path);
//                Encodage de l'image au format base64
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

//                Remplacement du lien de l'image a l'intérieur du contenu par l'image au format base64
                $newsletter->setContenu(str_replace($tag->getAttribute('src'), $base64, $newsletter->getContenu()));
            }

            $em->persist($newsletter);
            $em->flush($newsletter);

            return $this->redirectToRoute('newsletter_show', array('id' => $newsletter->getId()));
        }

        return $this->render('@Ruralis/admin/newsletter/new.html.twig', array(
            'newsletter' => $newsletter,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a newsletter entity.
     *
     */
    public function showAction(Newsletter $newsletter)
    {
        return $this->render('@Ruralis/admin/newsletter/show.html.twig', array(
            'newsletter' => $newsletter,
        ));
    }

    /**
     * Displays a form to edit an existing newsletter entity.
     *
     */
    public function editAction(Request $request, Newsletter $newsletter)
    {
        $editForm = $this->createForm('RuralisBundle\Form\NewsletterType', $newsletter);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newsletter_edit', array('id' => $newsletter->getId()));
        }

        return $this->render('@Ruralis/admin/newsletter/edit.html.twig', array(
            'newsletter' => $newsletter,
            'edit_form' => $editForm->createView(),
        ));
    }

    public function deleteAction($id)
    {
//        Si l'$id est définie alors :
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            // Recherche LA NEWSLETTER à supprimer parmi LES ARTICLES
            $newsletter = $em->getRepository('RuralisBundle:Newsletter')->findOneById($id);
            $em->remove($newsletter);
            // Envoie la requête à la BDD
            $em->flush();
            return $this->redirectToRoute('newsletter_index');
        } else
            return $this->redirectToRoute('newsletter_index');
    }

    public function sendAction($id, Newsletter $newsletters)
    {
        $em = $this->getDoctrine()->getManager();
        $abonnesNl = $em->getRepository('RuralisBundle:Abonnement')->findByNewsletter(true);
        $mailAboNl = $em->getRepository('RuralisBundle:Abonnement')->ContactAboNewsletter();
        $newsletter = $em->getRepository('RuralisBundle:Newsletter')->findOneById($id);


        //Structure du mail à enovyer
        $from = $this->getParameter('mailer_user');

        // Instanciation des variables mail, titre, contenu pour récupérer la data
/*        $email = $mailAboNl;*/

        $emails=[];

        foreach ($mailAboNl as $value) {
            $emails[] = $value['email'];
        }
        $titre = $newsletter->getTitre();
        $contenu = $newsletter->getContenu();
        $envoi = $newsletter->setEnvoi(true);
        $em->persist($envoi);
        $em->flush();


        $message = \Swift_Message::newInstance();
        $cid = $message->embed(\Swift_Image::fromPath('../web/bundles/ruralis/images/Logo_Ruralis.png'));
        $message
            ->setSubject($titre)
            ->setFrom(array($from => 'Ruralis Magazine'))
            ->setBcc($emails)
            ->setBody(
                $this->renderView(
                    '@Ruralis/user/newsletter.html.twig',
                    array(
                        'titre' => $titre,
                        'cid' => $cid,
                        'contenu' => $contenu,
                    )
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);

        //Renvoie vers la vue index, avec "newsletter envoyée cochée"
        return $this->redirectToRoute('newsletter_index', array(
            'newsletters' => $newsletters
            ));
    }
}
