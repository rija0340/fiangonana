<?php

namespace App\Entity;

use App\Repository\ThemeHiraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\BrowserKit\History;

/**
 * @ORM\Entity(repositoryClass=ThemeHiraRepository::class)
 */
class ThemeHira
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
     * @ORM\OneToMany(targetEntity=HiraChoral::class, mappedBy="theme")
     */
    private $hiraChorals;

    public function __construct()
    {
        $this->hiraChorals = new ArrayCollection();
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

    /**
     * @return Collection|HiraChoral[]
     */
    public function getHiraChorals(): Collection
    {
        return $this->hiraChorals;
    }

    public function addHiraChoral(HiraChoral $hiraChoral): self
    {
        if (!$this->hiraChorals->contains($hiraChoral)) {
            $this->hiraChorals[] = $hiraChoral;
            $hiraChoral->setTheme($this);
        }

        return $this;
    }

    public function removeHiraChoral(HiraChoral $hiraChoral): self
    {
        if ($this->hiraChorals->removeElement($hiraChoral)) {
            // set the owning side to null (unless already changed)
            if ($hiraChoral->getTheme() === $this) {
                $hiraChoral->setTheme(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
