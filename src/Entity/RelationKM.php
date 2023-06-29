<?php

namespace App\Entity;

use App\Repository\RelationKMRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelationKMRepository::class)
 */
class RelationKM
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isMpanentana;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isMpampianatra;

    /**
     * @ORM\ManyToOne(targetEntity=Kilasy::class)
     */
    private $kilasy;

    /**
     * @ORM\ManyToOne(targetEntity=Mambra::class)
     */
    private $mambra;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isMambraTsotra;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isCurrent;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getIsMpanentana(): ?bool
    {
        return $this->isMpanentana;
    }

    public function setIsMpanentana(?bool $isMpanentana): self
    {
        $this->isMpanentana = $isMpanentana;

        return $this;
    }

    public function getIsMpampianatra(): ?bool
    {
        return $this->isMpampianatra;
    }

    public function setIsMpampianatra(?bool $isMpampianatra): self
    {
        $this->isMpampianatra = $isMpampianatra;

        return $this;
    }

    public function getKilasy(): ?Kilasy
    {
        return $this->kilasy;
    }

    public function setKilasy(?Kilasy $kilasy): self
    {
        $this->kilasy = $kilasy;

        return $this;
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

    public function getIsMambraTsotra(): ?bool
    {
        return $this->isMambraTsotra;
    }

    public function setIsMambraTsotra(?bool $isMambraTsotra): self
    {
        $this->isMambraTsotra = $isMambraTsotra;

        return $this;
    }

    public function getIsCurrent(): ?bool
    {
        return $this->isCurrent;
    }

    public function setIsCurrent(?bool $isCurrent): self
    {
        $this->isCurrent = $isCurrent;

        return $this;
    }
}
