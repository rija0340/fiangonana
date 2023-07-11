<?php

namespace App\Entity;

use App\Repository\FianaranaLesonaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FianaranaLesonaRepository::class)
 */
class FianaranaLesona
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Mambra::class, inversedBy="fianaranaLesonas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mambra;



    /**
     * @ORM\Column(type="boolean")
     */
    private $presence;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity=Registre::class, inversedBy="fianaranaLesonas")
     */
    private $registre;

    public function __construct()
    {
        $this->registre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMambra(): ?Mambra
    {
        return $this->mambra;
    }

    public function setMambra(?Mambra $mambra): self
    {
        $this->mambra = $mambra;

        return $this;
    }



    public function getPresence(): ?bool
    {
        return $this->presence;
    }

    public function setPresence(bool $presence): self
    {
        $this->presence = $presence;

        return $this;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getRegistre(): ?Registre
    {
        return $this->registre;
    }

    public function setRegistre(?Registre $registre): self
    {
        $this->registre = $registre;

        return $this;
    }
}
