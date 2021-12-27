<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
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
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;


    /**
     * @ORM\Column(type="date")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $estimation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $columnUpdate;

    /**
     * @ORM\ManyToOne(targetEntity=KanbanColumn::class, inversedBy="taskList")
     * @ORM\JoinColumn(nullable=false)
     */
    private $kanbanColumn;

    /**
     * @ORM\ManyToOne(targetEntity=Sprint::class, inversedBy="taskList")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sprint;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="tasks")
     */
    private $assignation;

    public function __construct()
    {
        $this->assignation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getEstimation(): ?int
    {
        return $this->estimation;
    }

    public function setEstimation(int $estimation): self
    {
        $this->estimation = $estimation;

        return $this;
    }

    public function getColumnUpdate(): ?string
    {
        return $this->columnUpdate;
    }

    public function setColumnUpdate(string $columnUpdate): self
    {
        $this->columnUpdate = $columnUpdate;

        return $this;
    }

    public function getKanbanColumn(): ?KanbanColumn
    {
        return $this->kanbanColumn;
    }

    public function setKanbanColumn(?KanbanColumn $kanbanColumn): self
    {
        $this->kanbanColumn = $kanbanColumn;

        return $this;
    }

    public function getSprint(): ?Sprint
    {
        return $this->sprint;
    }

    public function setSprint(?Sprint $sprint): self
    {
        $this->sprint = $sprint;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAssignation(): Collection
    {
        return $this->assignation;
    }

    public function addAssignation(User $assignation): self
    {
        if (!$this->assignation->contains($assignation)) {
            $this->assignation[] = $assignation;
        }

        return $this;
    }

    public function removeAssignation(User $assignation): self
    {
        $this->assignation->removeElement($assignation);

        return $this;
    }
}
