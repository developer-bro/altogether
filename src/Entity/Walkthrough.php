<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WalkthroughRepository")
 */
class Walkthrough
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
    private $first;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $second;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $third;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fourth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fifth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sixth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $seventh;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eighth;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirst(): ?string
    {
        return $this->first;
    }

    public function setFirst(?string $first): self
    {
        $this->first = $first;

        return $this;
    }

    public function getSecond(): ?string
    {
        return $this->second;
    }

    public function setSecond(?string $second): self
    {
        $this->second = $second;

        return $this;
    }

    public function getThird(): ?string
    {
        return $this->third;
    }

    public function setThird(?string $third): self
    {
        $this->third = $third;

        return $this;
    }

    public function getFourth(): ?string
    {
        return $this->fourth;
    }

    public function setFourth(?string $fourth): self
    {
        $this->fourth = $fourth;

        return $this;
    }

    public function getFifth(): ?string
    {
        return $this->fifth;
    }

    public function setFifth(?string $fifth): self
    {
        $this->fifth = $fifth;

        return $this;
    }

    public function getSixth(): ?string
    {
        return $this->sixth;
    }

    public function setSixth(?string $sixth): self
    {
        $this->sixth = $sixth;

        return $this;
    }

    public function getSeventh(): ?string
    {
        return $this->seventh;
    }

    public function setSeventh(?string $seventh): self
    {
        $this->seventh = $seventh;

        return $this;
    }

    public function getEighth(): ?string
    {
        return $this->eighth;
    }

    public function setEighth(?string $eighth): self
    {
        $this->eighth = $eighth;

        return $this;
    }
}
