<?php

namespace App\Entity;

use App\Entity\Snowtrick;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\TrickGroupRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TrickGroupRepository::class)]
class TrickGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Unique]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'trickGroup', targetEntity: Snowtrick::class)]
    private Collection $snowtricks;

    public function __construct()
    {
        $this->snowtricks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Snowtrick>
     */
    public function getSnowtricks(): Collection
    {
        return $this->snowtricks;
    }

    public function addSnowtrick(Snowtrick $snowtrick): self
    {
        if (!$this->snowtricks->contains($snowtrick)) {
            $this->snowtricks->add($snowtrick);
            $snowtrick->setTrickGroup($this);
        }

        return $this;
    }

    public function removeSnowtrick(Snowtrick $snowtrick): self
    {
        if ($this->snowtricks->removeElement($snowtrick)) {
            // set the owning side to null (unless already changed)
            if ($snowtrick->getTrickGroup() === $this) {
                $snowtrick->setTrickGroup(null);
            }
        }

        return $this;
    }
}
