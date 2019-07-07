<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobsRepository")
 */
class Jobs
{



    const NUM_ITEMS = 5;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comapnyName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateSaved;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateApplied;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $uri;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isApplied;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isFollowUp;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isInterview;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPostInterviewFollowUp;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateInitialFollowUp;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateInterviewPrep;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateInterview;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateThankYouLetter;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateFollowUp;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="job")
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getComapnyName(): ?string
    {
        return $this->comapnyName;
    }

    public function setComapnyName(?string $comapnyName): self
    {
        $this->comapnyName = $comapnyName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateSaved(): ?\DateTimeInterface
    {
        return $this->dateSaved;
    }

    public function setDateSaved(?\DateTimeInterface $dateSaved): self
    {
        $this->dateSaved = $dateSaved;

        return $this;
    }

    public function getDateApplied(): ?\DateTimeInterface
    {
        return $this->dateApplied;
    }

    public function setDateApplied(?\DateTimeInterface $dateApplied): self
    {
        $this->dateApplied = $dateApplied;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(?string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    public function getIsApplied(): ?bool
    {
        return $this->isApplied;
    }

    public function setIsApplied(?bool $isApplied): self
    {
        $this->isApplied = $isApplied;

        return $this;
    }

    public function getIsFollowUp(): ?bool
    {
        return $this->isFollowUp;
    }

    public function setIsFollowUp(?bool $isFollowUp): self
    {
        $this->isFollowUp = $isFollowUp;

        return $this;
    }

    public function getIsInterview(): ?bool
    {
        return $this->isInterview;
    }

    public function setIsInterview(?bool $isInterview): self
    {
        $this->isInterview = $isInterview;

        return $this;
    }

    public function getIsPostInterviewFollowUp(): ?bool
    {
        return $this->isPostInterviewFollowUp;
    }

    public function setIsPostInterviewFollowUp(?bool $isPostInterviewFollowUp): self
    {
        $this->isPostInterviewFollowUp = $isPostInterviewFollowUp;

        return $this;
    }

    public function getDateInitialFollowUp(): ?\DateTimeInterface
    {
        return $this->dateInitialFollowUp;
    }

    public function setDateInitialFollowUp(?\DateTimeInterface $dateInitialFollowUp): self
    {
        $this->dateInitialFollowUp = $dateInitialFollowUp;

        return $this;
    }

    public function getDateInterviewPrep(): ?\DateTimeInterface
    {
        return $this->dateInterviewPrep;
    }

    public function setDateInterviewPrep(?\DateTimeInterface $dateInterviewPrep): self
    {
        $this->dateInterviewPrep = $dateInterviewPrep;

        return $this;
    }

    public function getDateInterview(): ?\DateTimeInterface
    {
        return $this->dateInterview;
    }

    public function setDateInterview(?\DateTimeInterface $dateInterview): self
    {
        $this->dateInterview = $dateInterview;

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

    public function getDateFollowUp(): ?\DateTimeInterface
    {
        return $this->dateFollowUp;
    }

    public function setDateFollowUp(?\DateTimeInterface $dateFollowUp): self
    {
        $this->dateFollowUp = $dateFollowUp;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setJob($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getJob() === $this) {
                $task->setJob(null);
            }
        }

        return $this;
    }
}
