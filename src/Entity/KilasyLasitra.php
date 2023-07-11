<?php

namespace App\Entity;

use App\Repository\KilasyLasitraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KilasyLasitraRepository::class)
 */
class KilasyLasitra
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $trancheAge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Kilasy::class, mappedBy="kilasyLasitra", orphanRemoval=true)
     */
    private $kilasies;

    public function __construct()
    {
        $this->kilasies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTrancheAge(): ?string
    {
        return $this->trancheAge;
    }

    public function setTrancheAge(string $trancheAge): self
    {
        $this->trancheAge = $trancheAge;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Kilasy[]
     */
    public function getKilasies(): Collection
    {
        return $this->kilasies;
    }

    public function addKilasy(Kilasy $kilasy): self
    {
        if (!$this->kilasies->contains($kilasy)) {
            $this->kilasies[] = $kilasy;
            $kilasy->setKilasyLasitra($this);
        }

        return $this;
    }

    public function removeKilasy(Kilasy $kilasy): self
    {
        if ($this->kilasies->removeElement($kilasy)) {
            // set the owning side to null (unless already changed)
            if ($kilasy->getKilasyLasitra() === $this) {
                $kilasy->setKilasyLasitra(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getNom() . " (" . $this->getTrancheAge() . ')';
    }
}
