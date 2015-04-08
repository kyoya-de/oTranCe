<?php

namespace Otc\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class KeyGroup
 *
 * @package Otc\CoreBundle\Entity
 *
 * @ORM\Table(indexes={@ORM\Index(name="search_project", columns={"project"})})
 * @ORM\Entity()
 */
class KeyGroup
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
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Otc\CoreBundle\Entity\Project", inversedBy="keyGroup")
     * @ORM\JoinColumn(name="project", referencedColumnName="id", onDelete="CASCADE")
     */
    private $project;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @var LanguageKey[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Otc\CoreBundle\Entity\LanguageKey", mappedBy="id")
     */
    private $languageKeys;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->languageKeys = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return KeyGroup
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
     * Set project
     *
     * @param \Otc\CoreBundle\Entity\Project $project
     * @return KeyGroup
     */
    public function setProject(\Otc\CoreBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \Otc\CoreBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Add languageKeys
     *
     * @param \Otc\CoreBundle\Entity\LanguageKey $languageKeys
     * @return KeyGroup
     */
    public function addLanguageKey(\Otc\CoreBundle\Entity\LanguageKey $languageKeys)
    {
        $this->languageKeys[] = $languageKeys;

        return $this;
    }

    /**
     * Remove languageKeys
     *
     * @param \Otc\CoreBundle\Entity\LanguageKey $languageKeys
     */
    public function removeLanguageKey(\Otc\CoreBundle\Entity\LanguageKey $languageKeys)
    {
        $this->languageKeys->removeElement($languageKeys);
    }

    /**
     * Get languageKeys
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLanguageKeys()
    {
        return $this->languageKeys;
    }
}
