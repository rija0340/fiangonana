<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FamilleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * normalizationContext={
 *  "groups"={"famille_read"}
 * }
 * )
 * @ORM\Entity(repositoryClass=FamilleRepository::class)
 */
class Famille
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"famille_read"})
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"famille_read"})
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Mambra::class, mappedBy="famille", cascade={"remove"})
     * @Groups({"famille_read"})
     * 
     */
    private $mambras;



    public function __construct()
    {
        $this->mambras = new ArrayCollection();
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
     * @return Collection|Mambra[]
     */
    public function getMambras(): Collection
    {
        return $this->mambras;
    }

    public function addMambra(Mambra $mambra): self
    {
        if (!$this->mambras->contains($mambra)) {
            $this->mambras[] = $mambra;
            $mambra->setFamille($this);
        }

        return $this;
    }

    public function removeMambra(Mambra $mambra): self
    {
        if ($this->mambras->removeElement($mambra)) {
            // set the owning side to null (unless already changed)
            if ($mambra->getFamille() === $this) {
                $mambra->setFamille(null);
            }
        }

        return $this;
    }
}
