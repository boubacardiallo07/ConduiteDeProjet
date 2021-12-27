<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjectRepository;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $creationDate;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $backlogProduct;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $SprintsLog;

    /**
     * @ORM\OneToMany(targetEntity=Sprint::class, mappedBy="project", orphanRemoval=true)
     */
    private $sprintList;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="projects")
     */
    private $userList;

    public function __construct()
    {
        $this->sprintList = new ArrayCollection();
        $this->userList = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }


    public function getBacklogProduct(): ?string
    {
        return $this->backlogProduct;
    }

    public function setBacklogProduct(string $backlogProduct): self
    {
        $this->backlogProduct = $backlogProduct;

        return $this;
    }

    public function getSprintsLog(): ?string
    {
        return $this->SprintsLog;
    }

    public function setSprintsLog(string $SprintsLog): self
    {
        $this->SprintsLog = $SprintsLog;

        return $this;
    }

    /**
     * @return Collection|Sprint[]
     */
    public function getSprintList(): Collection
    {
        return $this->sprintList;
    }

    public function addSprintList(Sprint $sprintList): self
    {
        if (!$this->sprintList->contains($sprintList)) {
            $this->sprintList[] = $sprintList;
            $sprintList->setProject($this);
        }

        return $this;
    }

    public function removeSprintList(Sprint $sprintList): self
    {
        if ($this->sprintList->removeElement($sprintList)) {
            // set the owning side to null (unless already changed)
            if ($sprintList->getProject() === $this) {
                $sprintList->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserList(): Collection
    {
        return $this->userList;
    }

    public function addUserList(User $userList): self
    {
        if (!$this->userList->contains($userList)) {
            $this->userList[] = $userList;
        }

        return $this;
    }

    public function removeUserList(User $userList): self
    {
        $this->userList->removeElement($userList);

        return $this;
    }
}
