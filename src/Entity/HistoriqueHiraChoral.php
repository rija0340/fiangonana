<?php

namespace App\Entity;

use App\Repository\HistoriqueHiraChoralRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoriqueHiraChoralRepository::class)
 */
class HistoriqueHiraChoral
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $doneAt;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fotoana;

    /**
     * @ORM\ManyToMany(targetEntity=HiraChoral::class, inversedBy="historiqueHiraChorals")
     */
    private $hira;

    public function __construct()
    {
        $this->hira = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoneAt(): ?\DateTimeInterface
    {
        return $this->doneAt;
    }

    public function setDoneAt(\DateTimeInterface $doneAt): self
    {
        $this->doneAt = $doneAt;

        return $this;
    }

    public function getFotoana(): ?string
    {
        return $this->fotoana;
    }

    public function setFotoana(string $fotoana): self
    {
        $this->fotoana = $fotoana;

        return $this;
    }

    /**
     * @return Collection|HiraChoral[]
     */
    public function getHira(): Collection
    {
        return $this->hira;
    }

    public function addHira(HiraChoral $hira): self
    {
        if (!$this->hira->contains($hira)) {
            $this->hira[] = $hira;
        }

        return $this;
    }

    public function removeHira(HiraChoral $hira): self
    {
        $this->hira->removeElement($hira);

        return $this;
    }
}
