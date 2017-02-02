<?php

//Theme Name: Ruralis
//Authors: Marielle Lautrou and Aurore David


namespace RuralisBundle\Entity;

/**
 * Abonnement
 */
class Abonnement
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $newsletter;

    /**
     * @var \RuralisBundle\Entity\Contact
     */
    private $contact;

    /**
     * @var \RuralisBundle\Entity\TypeAbo
     */
    private $type_abo;

    /**
     * @var \RuralisBundle\Entity\Abonne
     */
    private $abonne;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     *
     * @return Abonnement
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return boolean
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Set contact
     *
     * @param \RuralisBundle\Entity\Contact $contact
     *
     * @return Abonnement
     */
    public function setContact(\RuralisBundle\Entity\Contact $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \RuralisBundle\Entity\Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set typeAbo
     *
     * @param \RuralisBundle\Entity\TypeAbo $typeAbo
     *
     * @return Abonnement
     */
    public function setTypeAbo(\RuralisBundle\Entity\TypeAbo $typeAbo = null)
    {
        $this->type_abo = $typeAbo;

        return $this;
    }

    /**
     * Get typeAbo
     *
     * @return \RuralisBundle\Entity\TypeAbo
     */
    public function getTypeAbo()
    {
        return $this->type_abo;
    }

    /**
     * Set abonne
     *
     * @param \RuralisBundle\Entity\Abonne $abonne
     *
     * @return Abonnement
     */
    public function setAbonne(\RuralisBundle\Entity\Abonne $abonne = null)
    {
        $this->abonne = $abonne;

        return $this;
    }

    /**
     * Get abonne
     *
     * @return \RuralisBundle\Entity\Abonne
     */
    public function getAbonne()
    {
        return $this->abonne;
    }
}
