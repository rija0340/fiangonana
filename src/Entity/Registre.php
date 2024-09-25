<?php

namespace App\Entity;

use App\Repository\RegistreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *  * @ApiResource(
 * normalizationContext={
 *  "groups"={"registre_read"}
 * }
 * )
 * @ORM\Entity(repositoryClass=RegistreRepository::class)
 */
class Registre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="integer")
     * @Groups({"registre_read"})
     */
    private $mambraTonga;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"registre_read"})
     */
    private $mpamangy;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"registre_read"})
     */
    private $nianatraImpito;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"registre_read"})
     */
    private $asaSoa;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"registre_read"})
     */
    private $fampianaranaBaiboly;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"registre_read"})
     */
    private $bokyTrakta;

    /**
     * @ORM\Column(type="integer")
     */
    private $semineraKaoferansa;

    /**
     * @ORM\Column(type="integer")
     */
    private $alasarona;

    /**
     * @ORM\Column(type="integer")
     */
    private $nahavitaFampTaratasy;

    /**
     * @ORM\Column(type="integer")
     */
    private $batisaTami;

    /**
     * @ORM\Column(type="float")
     * @Groups({"registre_read"})
     */
    private $fanatitra;


    /**
     * @ORM\Column(type="date")
     * @Groups({"registre_read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Kilasy::class, inversedBy="registres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $kilasy;

    /**
     * @ORM\OneToMany(targetEntity=FianaranaLesona::class, mappedBy="registre")
     */
    private $fianaranaLesonas;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"registre_read"})     * 
     */
    private $tongaRehetra;

    /**
     * @ORM\Column(type="integer")
     */
    private $asafi;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrMambraKilasy;


    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->fianaranaLesonas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMambraTonga(): ?int
    {
        return $this->mambraTonga;
    }

    public function setMambraTonga(int $mambraTonga): self
    {
        $this->mambraTonga = $mambraTonga;

        return $this;
    }

    public function getMpamangy(): ?int
    {
        return $this->mpamangy;
    }

    public function setMpamangy(int $mpamangy): self
    {
        $this->mpamangy = $mpamangy;

        return $this;
    }

    public function getNianatraImpito(): ?int
    {
        return $this->nianatraImpito;
    }

    public function setNianatraImpito(int $nianatraImpito): self
    {
        $this->nianatraImpito = $nianatraImpito;

        return $this;
    }

    public function getAsaSoa(): ?int
    {
        return $this->asaSoa;
    }

    public function setAsaSoa(int $asaSoa): self
    {
        $this->asaSoa = $asaSoa;

        return $this;
    }

    public function getFampianaranaBaiboly(): ?int
    {
        return $this->fampianaranaBaiboly;
    }

    public function setFampianaranaBaiboly(int $fampianaranaBaiboly): self
    {
        $this->fampianaranaBaiboly = $fampianaranaBaiboly;

        return $this;
    }

    public function getBokyTrakta(): ?int
    {
        return $this->bokyTrakta;
    }

    public function setBokyTrakta(int $bokyTrakta): self
    {
        $this->bokyTrakta = $bokyTrakta;

        return $this;
    }

    public function getSemineraKaoferansa(): ?int
    {
        return $this->semineraKaoferansa;
    }

    public function setSemineraKaoferansa(int $semineraKaoferansa): self
    {
        $this->semineraKaoferansa = $semineraKaoferansa;

        return $this;
    }

    public function getAlasarona(): ?int
    {
        return $this->alasarona;
    }

    public function setAlasarona(int $alasarona): self
    {
        $this->alasarona = $alasarona;

        return $this;
    }

    public function getNahavitaFampTaratasy(): ?int
    {
        return $this->nahavitaFampTaratasy;
    }

    public function setNahavitaFampTaratasy(int $nahavitaFampTaratasy): self
    {
        $this->nahavitaFampTaratasy = $nahavitaFampTaratasy;

        return $this;
    }

    public function getBatisaTami(): ?int
    {
        return $this->batisaTami;
    }

    public function setBatisaTami(int $batisaTami): self
    {
        $this->batisaTami = $batisaTami;

        return $this;
    }

    public function getFanatitra(): ?float
    {
        return $this->fanatitra;
    }

    public function setFanatitra(float $fanatitra): self
    {
        $this->fanatitra = $fanatitra;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
            $fianaranaLesona->setRegistre($this);
        }

        return $this;
    }

    public function removeFianaranaLesona(FianaranaLesona $fianaranaLesona): self
    {
        if ($this->fianaranaLesonas->removeElement($fianaranaLesona)) {
            // set the owning side to null (unless already changed)
            if ($fianaranaLesona->getRegistre() === $this) {
                $fianaranaLesona->setRegistre(null);
            }
        }

        return $this;
    }

    public function getTongaRehetra(): ?int
    {
        return $this->tongaRehetra;
    }

    public function setTongaRehetra(?int $tongaRehetra): self
    {
        $this->tongaRehetra = $tongaRehetra;

        return $this;
    }

    public function getAsafi(): ?int
    {
        return $this->asafi;
    }

    public function setAsafi(int $asafi): self
    {
        $this->asafi = $asafi;

        return $this;
    }

    public function getNbrMambraKilasy(): ?int
    {
        return $this->nbrMambraKilasy;
    }

    public function setNbrMambraKilasy(?int $nbrMambraKilasy): self
    {
        $this->nbrMambraKilasy = $nbrMambraKilasy;

        return $this;
    }
}
