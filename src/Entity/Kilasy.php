<?php

namespace App\Entity;

use App\Repository\KilasyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KilasyRepository::class)
 */
class Kilasy
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;



    /**
     * @ORM\ManyToOne(targetEntity=KilasyLasitra::class, inversedBy="kilasies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $kilasyLasitra;

    /**
     * @ORM\OneToMany(targetEntity=Registre::class, mappedBy="kilasy", orphanRemoval=true)
     */
    private $registres;

    public function __construct()
    {
        $this->registres = new ArrayCollection();
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
    public function __toString()
    {
        return $this->getNom();
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


    public function getKilasyLasitra(): ?KilasyLasitra
    {
        return $this->kilasyLasitra;
    }

    public function setKilasyLasitra(?KilasyLasitra $kilasyLasitra): self
    {
        $this->kilasyLasitra = $kilasyLasitra;

        return $this;
    }

    /**
     * @return Collection|Registre[]
     */
    public function getRegistres(): Collection
    {
        return $this->registres;
    }

    public function addRegistre(Registre $registre): self
    {
        if (!$this->registres->contains($registre)) {
            $this->registres[] = $registre;
            $registre->setKilasy($this);
        }

        return $this;
    }

    public function removeRegistre(Registre $registre): self
    {
        if ($this->registres->removeElement($registre)) {
            // set the owning side to null (unless already changed)
            if ($registre->getKilasy() === $this) {
                $registre->setKilasy(null);
            }
        }

        return $this;
    }
}
