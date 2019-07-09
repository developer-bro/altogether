<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fromName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $toName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dueDate;

    /**
     * @ORM\Column(type="text")
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jobs", inversedBy="tasks")
     */
    private $job;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isComplete;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateThankYouLetter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $taskStatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    public function setFromName(string $fromName): self
    {
        $this->fromName = $fromName;

        return $this;
    }

    public function getToName(): ?string
    {
        return $this->toName;
    }

    public function setToName(string $toName): self
    {
        $this->toName = $toName;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getJob(): ?Jobs
    {
        return $this->job;
    }

    public function setJob(?Jobs $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getIsComplete(): ?bool
    {
        return $this->isComplete;
    }

    public function setIsComplete(?bool $isComplete): self
    {
        $this->isComplete = $isComplete;

        return $this;
    }

    public function getDateThankYouLetter(): ?\DateTimeInterface
    {
        return $this->dateThankYouLetter;
    }

    public function setDateThankYouLetter(?\DateTimeInterface $dateThankYouLetter): self
    {
        $this->dateThankYouLetter = $dateThankYouLetter;

        return $this;
    }

    public function getTaskStatus(): ?string
    {
        return $this->taskStatus;
    }

    public function setTaskStatus(?string $taskStatus): self
    {
        $this->taskStatus = $taskStatus;

        return $this;
    }
}
