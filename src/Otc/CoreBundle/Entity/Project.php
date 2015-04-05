<?php

namespace Otc\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Project
 *
 * @package Otc\CoreBundle\Entity
 *
 * @ORM\Table()
 */
class Project
{

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length="75")
     */
    public $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    public $url;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    public $logo;
}
