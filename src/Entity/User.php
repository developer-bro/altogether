<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dob;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $passwordRequestToken;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailReqistrationToken;

   

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedinAccessToken;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Jobs", mappedBy="User")
     */
    private $jobs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Upload", mappedBy="user")
     */
    private $uploads;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="user")
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SavedJobSearches", mappedBy="user")
     */
    private $savedJobSearches;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $noOfAttempts;


    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAccountNonLocked;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $accountUnlockToken;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CVupload", mappedBy="user")
     */
    private $cVuploads;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone_type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedinId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $someid;

   

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
        $this->uploads = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->savedJobSearches = new ArrayCollection();
        $this->cVuploads = new ArrayCollection();
    }
    

    

   

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(?\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

    public function getPasswordRequestToken(): ?string
    {
        return $this->passwordRequestToken;
    }

    public function setPasswordRequestToken(?string $passwordRequestToken): self
    {
        $this->passwordRequestToken = $passwordRequestToken;

        return $this;
    }

    public function getEmailReqistrationToken(): ?string
    {
        return $this->emailReqistrationToken;
    }

    public function setEmailReqistrationToken(?string $emailReqistrationToken): self
    {
        $this->emailReqistrationToken = $emailReqistrationToken;

        return $this;
    }


    public function getLinkedinAccessToken(): ?string
    {
        return $this->linkedinAccessToken;
    }

    public function setLinkedinAccessToken(?string $linkedinAccessToken): self
    {
        $this->linkedinAccessToken = $linkedinAccessToken;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection|Jobs[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Jobs $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
            $job->setUser($this);
        }

        return $this;
    }

    public function removeJob(Jobs $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            // set the owning side to null (unless already changed)
            if ($job->getUser() === $this) {
                $job->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Upload[]
     */
    public function getUploads(): Collection
    {
        return $this->uploads;
    }

    public function addUpload(Upload $upload): self
    {
        if (!$this->uploads->contains($upload)) {
            $this->uploads[] = $upload;
            $upload->setUser($this);
        }

        return $this;
    }

    public function removeUpload(Upload $upload): self
    {
        if ($this->uploads->contains($upload)) {
            $this->uploads->removeElement($upload);
            // set the owning side to null (unless already changed)
            if ($upload->getUser() === $this) {
                $upload->setUser(null);
            }
        }

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
            $task->setUser($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getUser() === $this) {
                $task->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SavedJobSearches[]
     */
    public function getSavedJobSearches(): Collection
    {
        return $this->savedJobSearches;
    }

    public function addSavedJobSearch(SavedJobSearches $savedJobSearch): self
    {
        if (!$this->savedJobSearches->contains($savedJobSearch)) {
            $this->savedJobSearches[] = $savedJobSearch;
            $savedJobSearch->setUser($this);
        }

        return $this;
    }

    public function removeSavedJobSearch(SavedJobSearches $savedJobSearch): self
    {
        if ($this->savedJobSearches->contains($savedJobSearch)) {
            $this->savedJobSearches->removeElement($savedJobSearch);
            // set the owning side to null (unless already changed)
            if ($savedJobSearch->getUser() === $this) {
                $savedJobSearch->setUser(null);
            }
        }

        return $this;
    }

    public function getNoOfAttempts(): ?int
    {
        return $this->noOfAttempts;
    }

    public function setNoOfAttempts(?int $noOfAttempts): self
    {
        $this->noOfAttempts = $noOfAttempts;

        return $this;
    }

    public function getIsAccountNonLocked(): ?bool
    {
        return $this->isAccountNonLocked;
    }

    public function setIsAccountNonLocked(?bool $isAccountNonLocked): self
    {
        $this->isAccountNonLocked = $isAccountNonLocked;

        return $this;
    }

    public function getAccountUnlockToken(): ?string
    {
        return $this->accountUnlockToken;
    }

    public function setAccountUnlockToken(?string $accountUnlockToken): self
    {
        $this->accountUnlockToken = $accountUnlockToken;

        return $this;
    }

    /**
     * @return Collection|CVupload[]
     */
    public function getCVuploads(): Collection
    {
        return $this->cVuploads;
    }

    public function addCVupload(CVupload $cVupload): self
    {
        if (!$this->cVuploads->contains($cVupload)) {
            $this->cVuploads[] = $cVupload;
            $cVupload->setUser($this);
        }

        return $this;
    }

    public function removeCVupload(CVupload $cVupload): self
    {
        if ($this->cVuploads->contains($cVupload)) {
            $this->cVuploads->removeElement($cVupload);
            // set the owning side to null (unless already changed)
            if ($cVupload->getUser() === $this) {
                $cVupload->setUser(null);
            }
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhoneType(): ?int
    {
        return $this->phone_type;
    }

    public function setPhoneType(?int $phone_type): self
    {
        $this->phone_type = $phone_type;

        return $this;
    }

    public function getStreet1(): ?string
    {
        return $this->street1;
    }

    public function setStreet1(?string $street1): self
    {
        $this->street1 = $street1;

        return $this;
    }

    public function getStreet2(): ?string
    {
        return $this->street2;
    }

    public function setStreet2(?string $street2): self
    {
        $this->street2 = $street2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getLinkedinId(): ?string
    {
        return $this->linkedinId;
    }

    public function setLinkedinId(?string $linkedinId): self
    {
        $this->linkedinId = $linkedinId;

        return $this;
    }

    public function getSomeid(): ?string
    {
        return $this->someid;
    }

    public function setSomeid(?string $someid): self
    {
        $this->someid = $someid;

        return $this;
    }

    

   

    
}
