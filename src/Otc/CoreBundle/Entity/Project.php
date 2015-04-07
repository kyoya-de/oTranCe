<?php
namespace Otc\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Project
 *
 * @package Otc\CoreBundle\Entity
 *
 * @ORM\Table(indexes={@ORM\Index(name="search_name", columns={"name"})})
 * @ORM\Entity()
 */
class Project
{
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
     * @ORM\Column(type="string", length=75)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $email = "";

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $url = "";

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $logo = "";

    /**
     * @var Language
     *
     * @ORM\OneToOne(targetEntity="Otc\CoreBundle\Entity\Language", mappedBy="id")
     */
    private $defaultLanguage;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $fillUntranslated = false;

    /**
     * @var KeyGroup[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Otc\CoreBundle\Entity\KeyGroup", mappedBy="project")
     */
    private $keyGroups;

    function __construct()
    {
        $this->keyGroups = new ArrayCollection();
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return Language
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * @param Language $defaultLanguage
     */
    public function setDefaultLanguage(Language $defaultLanguage)
    {
        $this->defaultLanguage = $defaultLanguage;
    }

    /**
     * @return boolean
     */
    public function isFillUntranslated()
    {
        return $this->fillUntranslated;
    }

    /**
     * @param boolean $fillUntranslated
     */
    public function setFillUntranslated($fillUntranslated)
    {
        $this->fillUntranslated = $fillUntranslated;
    }

    /**
     * @return ArrayCollection|KeyGroup[]
     */
    public function getKeyGroups()
    {
        return $this->keyGroups;
    }

    /**
     * @param ArrayCollection|KeyGroup[] $keyGroups
     */
    public function setKeyGroups($keyGroups)
    {
        $this->keyGroups = $keyGroups;
    }

    /**
     * @param KeyGroup $keyGroup
     */
    public function addKeyGroup(KeyGroup $keyGroup)
    {
        $this->keyGroups->add($keyGroup);
    }

    /**
     * Get fillUntranslated
     *
     * @return boolean
     */
    public function getFillUntranslated()
    {
        return $this->fillUntranslated;
    }

    /**
     * Remove keyGroups
     *
     * @param \Otc\CoreBundle\Entity\KeyGroup $keyGroups
     */
    public function removeKeyGroup(\Otc\CoreBundle\Entity\KeyGroup $keyGroups)
    {
        $this->keyGroups->removeElement($keyGroups);
    }
}
