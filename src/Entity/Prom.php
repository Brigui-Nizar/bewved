<?php

namespace App\Entity;

use App\Repository\PromRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromRepository::class)]
class Prom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'prom', targetEntity: Learner::class)]
    private Collection $learners;

    public function __construct()
    {
        $this->learners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Learner>
     */
    public function getLearners(): Collection
    {
        return $this->learners;
    }

    public function addLearner(Learner $learner): static
    {
        if (!$this->learners->contains($learner)) {
            $this->learners->add($learner);
            $learner->setProm($this);
        }

        return $this;
    }

    public function removeLearner(Learner $learner): static
    {
        if ($this->learners->removeElement($learner)) {
            // set the owning side to null (unless already changed)
            if ($learner->getProm() === $this) {
                $learner->setProm(null);
            }
        }

        return $this;
    }
}
