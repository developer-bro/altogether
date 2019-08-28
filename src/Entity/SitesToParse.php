<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SitesToParseRepository")
 */
class SitesToParse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siteName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titleClass;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyClass;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $locationClass;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descriptionClass;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(?string $siteName): self
    {
        $this->siteName = $siteName;

        return $this;
    }

    public function getTitleClass(): ?string
    {
        return $this->titleClass;
    }

    public function setTitleClass(?string $titleClass): self
    {
        $this->titleClass = $titleClass;

        return $this;
    }

    public function getCompanyClass(): ?string
    {
        return $this->companyClass;
    }

    public function setCompanyClass(?string $companyClass): self
    {
        $this->companyClass = $companyClass;

        return $this;
    }

    public function getLocationClass(): ?string
    {
        return $this->locationClass;
    }

    public function setLocationClass(?string $locationClass): self
    {
        $this->locationClass = $locationClass;

        return $this;
    }

    public function getDescriptionClass(): ?string
    {
        return $this->descriptionClass;
    }

    public function setDescriptionClass(?string $descriptionClass): self
    {
        $this->descriptionClass = $descriptionClass;

        return $this;
    }
}
