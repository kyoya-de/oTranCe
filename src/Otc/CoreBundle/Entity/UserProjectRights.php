<?php

namespace Otc\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Otc\UserBundle\Entity\Role;
use Otc\UserBundle\Entity\User;

/**
 * Class UserProjectRights
 *
 * @package Otc\CoreBundle\Entity
 *
 * @ORM\Entity()
 */
class UserProjectRights
{

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Otc\CoreBundle\Entity\Project")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $project;

    /**
     * @var User[]|ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Otc\UserBundle\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @var Role
     *
     * @ORM\OneToOne(targetEntity="Otc\UserBundle\Entity\Role")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $role;


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
     * Set project
     *
     * @param \Otc\CoreBundle\Entity\Project $project
     * @return UserProjectRights
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
     * Set user
     *
     * @param \Otc\UserBundle\Entity\User $user
     * @return UserProjectRights
     */
    public function setUser(\Otc\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Otc\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set role
     *
     * @param \Otc\UserBundle\Entity\Role $role
     * @return UserProjectRights
     */
    public function setRole(\Otc\UserBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Otc\UserBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }
}
