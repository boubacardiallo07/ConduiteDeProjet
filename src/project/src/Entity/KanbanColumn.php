<?php

namespace App\Entity;

use App\Repository\KanbanColumnRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KanbanColumnRepository::class)
 */
class KanbanColumn
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
     * @ORM\Column(type="array")
     */
    private $orderList = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $nbMaxTasks;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="kanbanColumn", orphanRemoval=true)
     */
    private $taskList;

    /**
     * @ORM\ManyToOne(targetEntity=Sprint::class, inversedBy="kanbanTab")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sprint;

    public function __construct()
    {

        $this->taskList = new ArrayCollection();
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



    public function getOrderList(): ?array
    {
        return $this->orderList;
    }

    public function setOrderList(?array $orderList): self
    {
        $this->orderList = $orderList;

        return $this;
    }

    public function getNbMaxTasks(): ?int
    {
        return $this->nbMaxTasks;
    }

    public function setNbMaxTasks(int $nbMaxTasks): self
    {
        $this->nbMaxTasks = $nbMaxTasks;

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
            $taskList->setKanbanColumn($this);
        }

        return $this;
    }

    public function removeTaskList(Task $taskList): self
    {
        if ($this->taskList->removeElement($taskList)) {
            // set the owning side to null (unless already changed)
            if ($taskList->getKanbanColumn() === $this) {
                $taskList->setKanbanColumn(null);
            }
        }

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
}
