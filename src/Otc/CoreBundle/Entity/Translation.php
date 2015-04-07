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
     * @ORM\Column(type="integer", options={"unsigned"})
     * @ORM\ManyToOne(targetEntity="Otc\CoreBundle\Entity\LanguageKey", inversedBy="id")
     * @ORM\Id()
     */
    private $languageKey;

    /**
     * @var Language
     *
     * @ORM\Column(type="integer", options={"unsigned"})
     * @ORM\ManyToOne(targetEntity="Otc\CoreBundle\Entity\Language", inversedBy="id")
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
     * Set languageKey
     *
     * @param LanguageKey $languageKey
     * @return Translation
     */
    public function setLanguageKey(LanguageKey $languageKey)
    {
        $this->languageKey = $languageKey;

        return $this;
    }

    /**
     * Get languageKey
     *
     * @return LanguageKey
     */
    public function getLanguageKey()
    {
        return $this->languageKey;
    }

    /**
     * Set language
     *
     * @param Language $language
     * @return Translation
     */
    public function setLanguage(Language $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return integer
     */
    public function getLanguage()
    {
        return $this->language;
    }

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
     * @param string $lastUpdate
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
     * @return string
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }
}
