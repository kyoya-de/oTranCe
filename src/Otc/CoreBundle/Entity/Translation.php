<?php

namespace Otc\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Translation
 *
 * @package Otc\CoreBundle\Entity
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Translation
{

    /**
     * @var LanguageKey
     *
     * @ORM\ManyToOne(targetEntity="Otc\CoreBundle\Entity\LanguageKey", inversedBy="translations")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     * @ORM\Id()
     */
    private $languageKey;

    /**
     * @var Language
     *
     * @ORM\ManyToOne(targetEntity="Otc\CoreBundle\Entity\Language", inversedBy="translations")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     * @ORM\Id()
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $translation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $lastUpdate;


    /**
     * Set translation
     *
     * @param string $translation
     * @return Translation
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * Get translation
     *
     * @return string
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return Translation
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set languageKey
     *
     * @param \Otc\CoreBundle\Entity\LanguageKey $languageKey
     * @return Translation
     */
    public function setLanguageKey(\Otc\CoreBundle\Entity\LanguageKey $languageKey)
    {
        $this->languageKey = $languageKey;

        return $this;
    }

    /**
     * Get languageKey
     *
     * @return \Otc\CoreBundle\Entity\LanguageKey
     */
    public function getLanguageKey()
    {
        return $this->languageKey;
    }

    /**
     * Set language
     *
     * @param \Otc\CoreBundle\Entity\Language $language
     * @return Translation
     */
    public function setLanguage(\Otc\CoreBundle\Entity\Language $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \Otc\CoreBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
