<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SprintRepository;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @ORM\Entity(repositoryClass=SprintRepository::class)
 */
class Sprint
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $CreationDate;

    /**
     * @ORM\Column(type="date")
     */
    private $endingDate;


    /**
     * @ORM\Column(type="array")
     */
    private $dailyAndRestrospectivePlanning = [];

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="sprintList")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="sprint", orphanRemoval=true)
     */
    private $taskList;

    /**
     * @ORM\OneToMany(targetEntity=KanbanColumn::class, mappedBy="sprint", orphanRemoval=true)
     */
    private $kanbanTab;


    public function __construct()
    {
        $this->CreationDate = new DateTime();
        $this->endingDate = new DateTime();
        $this->taskList = new ArrayCollection();
        $this->kanbanTab = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->CreationDate;
    }

    public function setCreationDate(\DateTimeInterface $CreationDate): self
    {
        $this->CreationDate = $CreationDate;

        return $this;
    }

    public function getEndingDate(): ?\DateTimeInterface
    {
        return $this->endingDate;
    }

    public function setEndingDate(\DateTimeInterface $endingDate): self
    {
        $this->endingDate = $endingDate;

        return $this;
    }



    public function getDailyAndRestrospectivePlanning(): ?array
    {
        return $this->dailyAndRestrospectivePlanning;
    }

    public function setDailyAndRestrospectivePlanning(array $dailyAndRestrospectivePlanning): self
    {
        $this->dailyAndRestrospectivePlanning = $dailyAndRestrospectivePlanning;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTaskList(): Collection
    {
        return $this->taskList;
    }

    public function addTaskList(Task $taskList): self
    {
        if (!$this->taskList->contains($taskList)) {
            $this->taskList[] = $taskList;
            $taskList->setSprint($this);
        }

        return $this;
    }

    public function removeTaskList(Task $taskList): self
    {
        if ($this->taskList->removeElement($taskList)) {
            // set the owning side to null (unless already changed)
            if ($taskList->getSprint() === $this) {
                $taskList->setSprint(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|KanbanColumn[]
     */
    public function getKanbanTab(): Collection
    {
        return $this->kanbanTab;
    }

    public function addKanbanTab(KanbanColumn $kanbanTab): self
    {
        if (!$this->kanbanTab->contains($kanbanTab)) {
            $this->kanbanTab[] = $kanbanTab;
            $kanbanTab->setSprint($this);
        }

        return $this;
    }

    public function removeKanbanTab(KanbanColumn $kanbanTab): self
    {
        if ($this->kanbanTab->removeElement($kanbanTab)) {
            // set the owning side to null (unless already changed)
            if ($kanbanTab->getSprint() === $this) {
                $kanbanTab->setSprint(null);
            }
        }

        return $this;
    }
}
