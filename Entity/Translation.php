<?php

namespace Disjfa\TranslationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TranslationRepository")
 * @ORM\Table(name="disjfa_translations")
 */
class Translation
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="domain", type="string")
     */
    private $domain;

    /**
     * @var string
     * @ORM\Column(name="code", type="string")
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var string
     * @ORM\Column(name="locale", type="string")
     */
    private $locale;

    public function __construct(string $locale, string $domain, string $code, string $text)
    {
        $this->locale = $locale;
        $this->domain = $domain;
        $this->code = $code;
        $this->text = $text;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }
}
