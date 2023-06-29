<?php

namespace App\Entity;

use App\Repository\TypeHiraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeHiraRepository::class)
 */
class TypeHira
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
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Hira::class, mappedBy="type")
     */
    private $hiras;

    public function __construct()
    {
        $this->hiras = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Hira[]
     */
    public function getHiras(): Collection
    {
        return $this->hiras;
    }

    public function addHira(Hira $hira): self
    {
        if (!$this->hiras->contains($hira)) {
            $this->hiras[] = $hira;
            $hira->setType($this);
        }

        return $this;
    }

    public function removeHira(Hira $hira): self
    {
        if ($this->hiras->removeElement($hira)) {
            // set the owning side to null (unless already changed)
            if ($hira->getType() === $this) {
                $hira->setType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->type;
    }
}
