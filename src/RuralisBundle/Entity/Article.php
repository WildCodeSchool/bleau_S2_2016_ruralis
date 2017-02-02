<?php

namespace RuralisBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * Article
 */
class Article
{


    /* ----------------------------------GENERATED CODE------------------------------------ */
    
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $descriptif;

    /**
     * @var string
     */
    private $contenu;

    /**
     * @var string
     */
    private $auteur;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $typeAffichage;

    /**
     * @var \RuralisBundle\Entity\Image
     * @Assert\Valid()
     */
    private $image;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Article
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set descriptif
     *
     * @param string $descriptif
     *
     * @return Article
     */
    public function setDescriptif($descriptif)
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * Get descriptif
     *
     * @return string
     */
    public function getDescriptif()
    {
        return $this->descriptif;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Article
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set typeAffichage
     *
     * @param string $typeAffichage
     *
     * @return Article
     */
    public function setTypeAffichage($typeAffichage)
    {
        $this->typeAffichage = $typeAffichage;

        return $this;
    }

    /**
     * Get typeAffichage
     *
     * @return string
     */
    public function getTypeAffichage()
    {
        return $this->typeAffichage;
    }

    /**
     * Set image
     *
     * @param \RuralisBundle\Entity\Image $image
     *
     * @return Article
     */
    public function setImage(\RuralisBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \RuralisBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
