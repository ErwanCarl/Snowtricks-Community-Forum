<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le champ url doit être rempli.')]
    #[Assert\Url(message: 'L\'url {{ value }} n\'est pas valide.')]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $videoId = null;

    #[ORM\ManyToOne(inversedBy: 'videos', targetEntity: Snowtrick::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Snowtrick $snowtrick = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(string $videoId): self
    {
        $this->videoId = $videoId;

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
