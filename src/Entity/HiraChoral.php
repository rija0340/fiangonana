<?php

namespace App\Entity;

use App\Repository\HiraChoralRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HiraChoralRepository::class)
 */
class HiraChoral
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autheur;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=ThemeHira::class, inversedBy="hiraChorals")
     */
    private $theme;

    /**
     * @ORM\ManyToMany(targetEntity=HistoriqueHiraChoral::class, mappedBy="hira")
     */
    private $historiqueHiraChorals;

    public function __construct()
    {
        $this->historiqueHiraChorals = new ArrayCollection();
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

    public function getCle(): ?string
    {
        return $this->cle;
    }

    public function setCle(?string $cle): self
    {
        $this->cle = $cle;

        return $this;
    }

    public function getAutheur(): ?string
    {
        return $this->autheur;
    }

    public function setAutheur(?string $autheur): self
    {
        $this->autheur = $autheur;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTheme(): ?ThemeHira
    {
        return $this->theme;
    }

    public function setTheme(?ThemeHira $theme): self
    {
        $this->theme = $theme;

        return $this;
    }


    public function __toString()
    {
        return $this->titre;
    }

    /**
     * @return Collection|HistoriqueHiraChoral[]
     */
    public function getHistoriqueHiraChorals(): Collection
    {
        return $this->historiqueHiraChorals;
    }

    public function addHistoriqueHiraChoral(HistoriqueHiraChoral $historiqueHiraChoral): self
    {
        if (!$this->historiqueHiraChorals->contains($historiqueHiraChoral)) {
            $this->historiqueHiraChorals[] = $historiqueHiraChoral;
            $historiqueHiraChoral->addHira($this);
        }

        return $this;
    }

    public function removeHistoriqueHiraChoral(HistoriqueHiraChoral $historiqueHiraChoral): self
    {
        if ($this->historiqueHiraChorals->removeElement($historiqueHiraChoral)) {
            $historiqueHiraChoral->removeHira($this);
        }

        return $this;
    }
}
