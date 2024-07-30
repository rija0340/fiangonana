<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MambraRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 * normalizationContext={
 *  "groups"={"mambra_read"}
 * }
 * )
 * @ApiFilter(SearchFilter::class, properties={"sexe": "partial","nom" : "partial","prenom": "partial"})
 * @ApiFilter(BooleanFilter::class, properties={"baptise"})
 * @ORM\Entity(repositoryClass=MambraRepository::class)
 */
class Mambra
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"mambra_read", "famille_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable= true)
     * @Groups({"mambra_read", "famille_read"})
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Famille::class, inversedBy="mambras",cascade={"persist"})
     * @Groups({"mambra_read"})
     */
    private $famille;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"mambra_read", "famille_read"})
     */
    private $sexe;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"mambra_read", "famille_read"})
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"mambra_read", "famille_read"})
     */
    private $trancheAge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"mambra_read", "famille_read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"mambra_read", "famille_read"})
     */
    private $baptise;

    /**
     * @ORM\OneToMany(targetEntity=FianaranaLesona::class, mappedBy="mambra", orphanRemoval=true)
     * @ApiProperty(writable=false)
     */
    private $fianaranaLesonas;

    public function __construct()
    {
        $this->famille = new ArrayCollection();
        $this->fianaranaLesonas = new ArrayCollection();
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
     * @return Famille
     */
    public function getFamille()
    {
        return $this->famille;
    }

    public function setFamille(?Famille $famille): self
    {
        $this->famille = $famille;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }


    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getTrancheAge(): ?string
    {
        return $this->trancheAge;
    }

    public function setTrancheAge(?string $trancheAge): self
    {
        $this->trancheAge = $trancheAge;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getBaptise(): ?bool
    {
        return $this->baptise;
    }

    public function setBaptise(?bool $baptise): self
    {
        $this->baptise = $baptise;

        return $this;
    }

    public function __toString()
    {
        return $this->getNom() + "" + $this->getPrenom();
    }

    /**
     * @return Collection|FianaranaLesona[]
     */
    public function getFianaranaLesonas(): Collection
    {
        return $this->fianaranaLesonas;
    }

    public function addFianaranaLesona(FianaranaLesona $fianaranaLesona): self
    {
        if (!$this->fianaranaLesonas->contains($fianaranaLesona)) {
            $this->fianaranaLesonas[] = $fianaranaLesona;
            $fianaranaLesona->setMambra($this);
        }

        return $this;
    }

    public function removeFianaranaLesona(FianaranaLesona $fianaranaLesona): self
    {
        if ($this->fianaranaLesonas->removeElement($fianaranaLesona)) {
            // set the owning side to null (unless already changed)
            if ($fianaranaLesona->getMambra() === $this) {
                $fianaranaLesona->setMambra(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"mambra_read"})
     * @ApiProperty(writable=false)
     */
    public function getFamilleId(): ?int
    {
        return $this->famille ? $this->famille->getId() : null;
    }
}
