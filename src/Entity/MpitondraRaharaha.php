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
     * @ORM\Column(type="datetime")
     */
    private $date_sabata;

    /**
     * @ORM\ManyToOne(targetEntity=Mambra::class)
     */
    private $presides;

    /**
     * @ORM\ManyToOne(targetEntity=Mambra::class)
     */
    private $dimy_minitra;

    /**
     * @ORM\ManyToOne(targetEntity=Mambra::class)
     */
    private $Lesona;

    /**
     * @ORM\ManyToOne(targetEntity=Mambra::class)
     */
    private $Mpitory_teny;


    /**
     * @ORM\ManyToOne(targetEntity=Mambra::class)
     */
    private $Alarobia;

    /**
     * @ORM\ManyToOne(targetEntity=Mambra::class)
     */
    private $presides_hariva;

    /**
     * @ORM\ManyToOne(targetEntity=Mambra::class)
     */
    private $tmt;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getDateSabata(): ?\DateTimeInterface
    {
        return $this->date_sabata;
    }

    public function setDateSabata(\DateTimeInterface $date_sabata): self
    {
        $this->date_sabata = $date_sabata;

        return $this;
    }

    public function getPresides(): ?Mambra
    {
        return $this->presides;
    }

    public function setPresides(?Mambra $presides): self
    {
        $this->presides = $presides;

        return $this;
    }

    public function getDimyMinitra(): ?Mambra
    {
        return $this->dimy_minitra;
    }

    public function setDimyMinitra(?Mambra $dimy_minitra): self
    {
        $this->dimy_minitra = $dimy_minitra;

        return $this;
    }

    public function getLesona(): ?Mambra
    {
        return $this->Lesona;
    }

    public function setLesona(?Mambra $Lesona): self
    {
        $this->Lesona = $Lesona;

        return $this;
    }

    public function getMpitoryTeny(): ?Mambra
    {
        return $this->Mpitory_teny;
    }

    public function setMpitoryTeny(?Mambra $Mpitory_teny): self
    {
        $this->Mpitory_teny = $Mpitory_teny;

        return $this;
    }



    public function getAlarobia(): ?Mambra
    {
        return $this->Alarobia;
    }

    public function setAlarobia(?Mambra $Alarobia): self
    {
        $this->Alarobia = $Alarobia;

        return $this;
    }

    public function getPresidesHariva(): ?Mambra
    {
        return $this->presides_hariva;
    }

    public function setPresidesHariva(?Mambra $presides_hariva): self
    {
        $this->presides_hariva = $presides_hariva;

        return $this;
    }

    public function getTmt(): ?Mambra
    {
        return $this->tmt;
    }

    public function setTmt(?Mambra $tmt): self
    {
        $this->tmt = $tmt;

        return $this;
    }
}
