<?php

namespace App\Entity;

use App\Repository\CleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CleRepository::class)
 */
class Cle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cle;

    /**
     * @ORM\OneToMany(targetEntity=Hira::class, mappedBy="cle")
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

    public function getCle(): ?string
    {
        return $this->cle;
    }

    public function setCle(?string $cle): self
    {
        $this->cle = $cle;

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
            $hira->setCle($this);
        }

        return $this;
    }

    public function removeHira(Hira $hira): self
    {
        if ($this->hiras->removeElement($hira)) {
            // set the owning side to null (unless already changed)
            if ($hira->getCle() === $this) {
                $hira->setCle(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->cle;
    }
}
