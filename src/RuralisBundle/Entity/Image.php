<?php

namespace RuralisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 */
class Image
{
    public function __toString()
    {
        return $this->url;
    }

    /**
     * @Assert\Image(
     *     maxSize = "1k",
     *     mimeTypes = {"image/*"},
     *     maxSizeMessage = "The maxmimum allowed file size is 1MB.",
     *     mimeTypesMessage = "Please upload a valid Image.")
     */
    public $file;

    protected function getUploadDir()
    {
        return 'images';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return null === $this->url ? null : $this->getUploadDir().'/'.$this->url;
    }

    public function getAbsolutePath()
    {
        return null === $this->url ? null : $this->getUploadRootDir().'/'.$this->url;
    }


    /**
     * @ORM\PrePersist
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // "uniquid()" permet de créer une id de manière aléatoire
            // Récupère l'extension du fichier
            $this->url = uniqid().'.'.$this->file->guessExtension();
        }
    }


    /**
     * @ORM\PostPersist
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
// If there is an error when moving the file, an exception will
// be automatically thrown by move(). This will properly prevent
// the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->url);

        unset($this->file);
    }


    /**
     * @ORM\PostRemove
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }


    /*---------------GENERATED CODE---------------------*/


    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $alt;

    /**
     * @var string
     */
    private $url;


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
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
