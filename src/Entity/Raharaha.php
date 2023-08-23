<?php

namespace App\Entity;

use App\Repository\RaharahaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RaharahaRepository::class)
 */
class Raharaha
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
    private $andraikitra;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $abbreviation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAndraikitra(): ?string
    {
        return $this->andraikitra;
    }

    public function setAndraikitra(string $andraikitra): self
    {
        $this->andraikitra = $andraikitra;

        return $this;
    }

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }
    public function __toString()
    {
        return $this->andraikitra;
    }
}
