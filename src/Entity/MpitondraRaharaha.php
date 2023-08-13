<?php

namespace App\Entity;

use App\Repository\MpitondraRaharahaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MpitondraRaharahaRepository::class)
 */
class MpitondraRaharaha
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Raharaha::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $andraikitra;

    /**
     * @ORM\ManyToOne(targetEntity=Mambra::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $mambra;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAndraikitra(): ?Raharaha
    {
        return $this->andraikitra;
    }

    public function setAndraikitra(?Raharaha $andraikitra): self
    {
        $this->andraikitra = $andraikitra;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
