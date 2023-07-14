<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FileRepository;
use Symfony\Component\HttpFoundation\File\File As SymfonyFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=FileRepository::class)
 * @Vich\Uploadable
 */
class File
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
    private $filename;

    /**
     * @Vich\UploadableField(mapping="uploaded_file", fileNameProperty="filename")
     */
    private $file;


    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFile(?SymfonyFile $file)
    {

        $this->file = $file;
        
        if ($this->file instanceof UploadedFile) {
            $this->updatedAt = new \Datetime('now');            
        }

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function __toString()
    {
        return $this->filename ?? '' ;
    }
}
