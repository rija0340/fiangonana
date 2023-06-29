<?php

namespace App\Entity;

use App\Repository\HiraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HiraRepository::class)
 */
class Hira
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
    private $titre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numero;

    /**
     * @ORM\OneToMany(targetEntity=Tononkira::class, mappedBy="hira")
     */
    private $tononkiras;

    /**
     * @ORM\ManyToOne(targetEntity=Cle::class, inversedBy="hiras")
     */
    private $cle;

    /**
     * @ORM\ManyToOne(targetEntity=TypeHira::class, inversedBy="hiras")
     */
    private $type;

    public function __construct()
    {
        $this->tononkiras = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }



    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection|Tononkira[]
     */
    public function getTononkiras(): Collection
    {
        return $this->tononkiras;
    }

    public function addTononkira(Tononkira $tononkira): self
    {
        if (!$this->tononkiras->contains($tononkira)) {
            $this->tononkiras[] = $tononkira;
            $tononkira->setHira($this);
        }

        return $this;
    }

    public function removeTononkira(Tononkira $tononkira): self
    {
        if ($this->tononkiras->removeElement($tononkira)) {
            // set the owning side to null (unless already changed)
            if ($tononkira->getHira() === $this) {
                $tononkira->setHira(null);
            }
        }

        return $this;
    }

    public function getCle(): ?Cle
    {
        return $this->cle;
    }

    public function setCle(?Cle $cle): self
    {
        $this->cle = $cle;

        return $this;
    }

    public function getType(): ?TypeHira
    {
        return $this->type;
    }

    public function setType(?TypeHira $type): self
    {
        $this->type = $type;

        return $this;
    }
}
