<?php

namespace Otc\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Project
 *
 * @package Otc\CoreBundle\Entity
 *
 * @ORM\Table(indexes={@ORM\Index(name="search_locale", columns={"locale"})})
 * @ORM\Entity()
 */
class Language
{

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $flag = "";

    /**
     * @var Translation[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Otc\CoreBundle\Entity\Translation", mappedBy="language")
     */
    private $translations;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * @param string $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add translations
     *
     * @param \Otc\CoreBundle\Entity\Translation $translations
     * @return Language
     */
    public function addTranslation(\Otc\CoreBundle\Entity\Translation $translations)
    {
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Otc\CoreBundle\Entity\Translation $translations
     */
    public function removeTranslation(\Otc\CoreBundle\Entity\Translation $translations)
    {
        $this->translations->removeElement($translations);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}
