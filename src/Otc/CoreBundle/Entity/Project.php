<?php
namespace Otc\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Otc\UserBundle\Entity\User;

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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Otc\UserBundle\Entity\User", inversedBy="ownProjects")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $owner;

    /**
     * @var Language
     *
     * @ORM\ManyToOne(targetEntity="Otc\CoreBundle\Entity\Language")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
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

    /**
     * @var User[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Otc\CoreBundle\Entity\UserProjectRights", mappedBy="project")
     */
    private $userRights;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->keyGroups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userRights = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Project
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
     * Set email
     *
     * @param string $email
     * @return Project
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Project
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

    /**
     * Set logo
     *
     * @param string $logo
     * @return Project
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set fillUntranslated
     *
     * @param boolean $fillUntranslated
     * @return Project
     */
    public function setFillUntranslated($fillUntranslated)
    {
        $this->fillUntranslated = $fillUntranslated;

        return $this;
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
     * Set owner
     *
     * @param \Otc\UserBundle\Entity\User $owner
     * @return Project
     */
    public function setOwner(\Otc\UserBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Otc\UserBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set defaultLanguage
     *
     * @param \Otc\CoreBundle\Entity\Language $defaultLanguage
     * @return Project
     */
    public function setDefaultLanguage(\Otc\CoreBundle\Entity\Language $defaultLanguage = null)
    {
        $this->defaultLanguage = $defaultLanguage;

        return $this;
    }

    /**
     * Get defaultLanguage
     *
     * @return \Otc\CoreBundle\Entity\Language 
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * Add keyGroups
     *
     * @param \Otc\CoreBundle\Entity\KeyGroup $keyGroups
     * @return Project
     */
    public function addKeyGroup(\Otc\CoreBundle\Entity\KeyGroup $keyGroups)
    {
        $this->keyGroups[] = $keyGroups;

        return $this;
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

    /**
     * Get keyGroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getKeyGroups()
    {
        return $this->keyGroups;
    }

    /**
     * Add userRights
     *
     * @param \Otc\CoreBundle\Entity\UserProjectRights $userRights
     * @return Project
     */
    public function addUserRight(\Otc\CoreBundle\Entity\UserProjectRights $userRights)
    {
        $this->userRights[] = $userRights;

        return $this;
    }

    /**
     * Remove userRights
     *
     * @param \Otc\CoreBundle\Entity\UserProjectRights $userRights
     */
    public function removeUserRight(\Otc\CoreBundle\Entity\UserProjectRights $userRights)
    {
        $this->userRights->removeElement($userRights);
    }

    /**
     * Get userRights
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserRights()
    {
        return $this->userRights;
    }
}
