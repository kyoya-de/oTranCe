<?php

namespace Otc\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Otc\CoreBundle\Entity\Project;
use Otc\CoreBundle\Entity\UserProjectRights;

/**
 * Class User
 *
 * @package Otc\UserBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="OtcUser")
 */
class User extends BaseUser
{

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $realName;

    /**
     * @var Project[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Otc\CoreBundle\Entity\Project", mappedBy="owner")
     */
    protected $ownProjects;

    /**
     * @var UserProjectRights[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Otc\CoreBundle\Entity\UserProjectRights", mappedBy="user")
     */
    protected $projectRights;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ownProjects = new \Doctrine\Common\Collections\ArrayCollection();
        $this->projectRights = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set realName
     *
     * @param string $realName
     * @return User
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;

        return $this;
    }

    /**
     * Get realName
     *
     * @return string 
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * Add ownProjects
     *
     * @param \Otc\CoreBundle\Entity\Project $ownProjects
     * @return User
     */
    public function addOwnProject(\Otc\CoreBundle\Entity\Project $ownProjects)
    {
        $this->ownProjects[] = $ownProjects;

        return $this;
    }

    /**
     * Remove ownProjects
     *
     * @param \Otc\CoreBundle\Entity\Project $ownProjects
     */
    public function removeOwnProject(\Otc\CoreBundle\Entity\Project $ownProjects)
    {
        $this->ownProjects->removeElement($ownProjects);
    }

    /**
     * Get ownProjects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwnProjects()
    {
        return $this->ownProjects;
    }

    /**
     * Add projectRights
     *
     * @param \Otc\CoreBundle\Entity\UserProjectRights $projectRights
     * @return User
     */
    public function addProjectRight(\Otc\CoreBundle\Entity\UserProjectRights $projectRights)
    {
        $this->projectRights[] = $projectRights;

        return $this;
    }

    /**
     * Remove projectRights
     *
     * @param \Otc\CoreBundle\Entity\UserProjectRights $projectRights
     */
    public function removeProjectRight(\Otc\CoreBundle\Entity\UserProjectRights $projectRights)
    {
        $this->projectRights->removeElement($projectRights);
    }

    /**
     * Get projectRights
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjectRights()
    {
        return $this->projectRights;
    }
}
