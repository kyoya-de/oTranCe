<?php

namespace Otc\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class LanguageKey
 *
 * @package Otc\CoreBundle\Entity
 *
 * @ORM\Table(indexes={@ORM\Index(name="search_key", columns={"keyGroup"})})
 * @ORM\Entity()
 */
class LanguageKey {

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={"unsigned"})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var KeyGroup
     *
     * @ORM\Column(type="integer", options={"unsigned"})
     * @ORM\ManyToOne(targetEntity="Otc\CoreBundle\Entity\KeyGroup", inversedBy="languageKeys")
     */
    private $keyGroup;

    /**
     * @var Translation[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Otc\CoreBundle\Entity\Translation", mappedBy="languageKey")
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
     * @return KeyGroup
     */
    public function getKeyGroup()
    {
        return $this->keyGroup;
    }

    /**
     * @param KeyGroup $keyGroup
     */
    public function setKeyGroup(KeyGroup $keyGroup)
    {
        $this->keyGroup = $keyGroup;
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
     * @return LanguageKey
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
