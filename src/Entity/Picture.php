<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PictureRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
#[UniqueEntity('fileName', message : 'Ce nom de fichier existe déjà.')]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $fileName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\File(
        maxSize: '1M',
        extensions: ['jpg','jpeg','png'],
        maxSizeMessage: 'L\'image ne doit pas excéder 1 Mo',
        extensionsMessage: 'Le format n\'est pas valide, les formats autorisés sont JPG, JPEG et PNG.',
    )]
    private ?string $file = null;

    #[ORM\ManyToOne(inversedBy: 'pictures', targetEntity: Snowtrick::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Snowtrick $snowtrick = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getSnowtrick(): ?Snowtrick
    {
        return $this->snowtrick;
    }

    public function setSnowtrick(?Snowtrick $snowtrick): self
    {
        $this->snowtrick = $snowtrick;

        return $this;
    }
}
