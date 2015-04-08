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
     * @ORM\ManyToOne(targetEntity="Otc\CoreBundle\Entity\KeyGroup", inversedBy="languageKeys")
     * @ORM\JoinColumn(name="keyGroup", referencedColumnName="id", onDelete="CASCADE")
     */
    private $keyGroup;

    /**
     * @var Translation[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Otc\CoreBundle\Entity\Translation", mappedBy="languageKey")
     */
    private $translations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return LanguageKey
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set keyGroup
     *
     * @param \Otc\CoreBundle\Entity\KeyGroup $keyGroup
     * @return LanguageKey
     */
    public function setKeyGroup(\Otc\CoreBundle\Entity\KeyGroup $keyGroup = null)
    {
        $this->keyGroup = $keyGroup;

        return $this;
    }

    /**
     * Get keyGroup
     *
     * @return \Otc\CoreBundle\Entity\KeyGroup
     */
    public function getKeyGroup()
    {
        return $this->keyGroup;
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
