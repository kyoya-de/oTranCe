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
     * @ORM\Column(type="integer", options={"unsigned"})
     * @ORM\ManyToOne(targetEntity="Otc\CoreBundle\Entity\Project", inversedBy="keyGroups")
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
     *
     */
    function __construct()
    {
        $this->languageKeys = new ArrayCollection();
    }

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
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject($project)
    {
        $this->project = $project;
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
     * @return LanguageKey[]
     */
    public function getLanguageKeys()
    {
        return $this->languageKeys;
    }

    /**
     * @param LanguageKey[] $languageKeys
     */
    public function setLanguageKeys($languageKeys)
    {
        $this->languageKeys = $languageKeys;
    }

    /**
     * @param LanguageKey $languageKey
     */
    public function addKey(LanguageKey $languageKey)
    {
        $this->languageKeys->add($languageKey);
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
}
