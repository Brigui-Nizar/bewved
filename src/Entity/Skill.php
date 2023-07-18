<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'skills')]
    private ?SkillGroup $skillGroup = null;

    #[ORM\ManyToMany(targetEntity: Learner::class, mappedBy: 'skills')]
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

    public function getSkillGroup(): ?SkillGroup
    {
        return $this->skillGroup;
    }

    public function setSkillGroup(?SkillGroup $skillGroup): static
    {
        $this->skillGroup = $skillGroup;

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
            $learner->addSkill($this);
        }

        return $this;
    }

    public function removeLearner(Learner $learner): static
    {
        if ($this->learners->removeElement($learner)) {
            $learner->removeSkill($this);
        }

        return $this;
    }
}
