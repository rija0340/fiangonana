<?php

namespace App\Entity;

use App\Repository\VerificationMoisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VerificationMoisRepository::class)
 */
class VerificationMois
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mois;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rempli;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(?string $mois): self
    {
        $this->mois = $mois;

        return $this;
    }

    public function getRempli(): ?bool
    {
        return $this->rempli;
    }

    public function setRempli(?bool $rempli): self
    {
        $this->rempli = $rempli;

        return $this;
    }
}
