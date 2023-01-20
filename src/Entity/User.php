<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', message : 'Le mail est déjà utilisé sur un autre compte utilisateur.')]
#[UniqueEntity('accountKey')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le nom doit être renseigné.')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le nom doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le nom ne peut excéder {{ limit }} caractères.',
    )]
    #[Assert\Regex(
        pattern: "/^([a-zA-Z']{2,50})$/",
        message: 'Le nom doit seulement contenir des lettres.'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le prénom doit être renseigné.')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le prénom doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le prénom ne peut excéder {{ limit }} caractères.',
    )]
    #[Assert\Regex(
        pattern: "/^([a-zA-Z' ]{2,50})$/",
        message: 'Le prénom doit seulement contenir des lettres.'
    )]
    private ?string $nickname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le mail doit être renseigné.')]
    #[Assert\Email(message: 'Le format de l\'email n\'est pas valide.',)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'L\'email ne peut excéder {{ limit }} caractères.',
    )]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le mot de passe doit être renseigné.')]
    #[Assert\Length(
        min: 8,
        max: 255,
        minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le mot de passe ne peut excéder {{ limit }} caractères.',
    )]
    #[Assert\Regex(
        pattern: '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
        message: 'Le mot de passe doit contenir au moins 8 caractères, 1 majuscule, 1 minuscule et 1 caractère spécial.'
    )]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\File(
        maxSize: '1M',
        extensions: ['jpg','jpeg','png'],
        maxSizeMessage: 'L\'image ne doit pas excéder 1 Mo',
        extensionsMessage: 'Le format n\'est pas valide, les formats autorisés sont JPG, JPEG et PNG.',
    )]
    private ?string $logo = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private array $roles = [];

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?bool $validateAccount = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accountKey = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Snowtrick::class, orphanRemoval: true)]
    private Collection $snowtricks;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ChatMessage::class, orphanRemoval: true)]
    private Collection $chatMessages;


    public function __construct()
    {
        $this->snowtricks = new ArrayCollection();
        $this->chatMessages = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function isValidateAccount(): ?bool
    {
        return $this->validateAccount;
    }

    public function setValidateAccount(bool $validateAccount): self
    {
        $this->validateAccount = $validateAccount;

        return $this;
    }

    public function getAccountKey(): ?string
    {
        return $this->accountKey;
    }

    public function setAccountKey(?string $accountKey): self
    {
        $this->accountKey = $accountKey;

        return $this;
    }

    /**
     * @return Collection<int, Snowtrick>
     */
    public function getSnowtricks(): Collection
    {
        return $this->snowtricks;
    }

    public function addSnowtrick(Snowtrick $snowtrick): self
    {
        if (!$this->snowtricks->contains($snowtrick)) {
            $this->snowtricks->add($snowtrick);
            $snowtrick->setUser($this);
        }

        return $this;
    }

    public function removeSnowtrick(Snowtrick $snowtrick): self
    {
        if ($this->snowtricks->removeElement($snowtrick)) {
            // set the owning side to null (unless already changed)
            if ($snowtrick->getUser() === $this) {
                $snowtrick->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChatMessage>
     */
    public function getChatMessages(): Collection
    {
        return $this->chatMessages;
    }

    public function addChatMessage(ChatMessage $chatMessage): self
    {
        if (!$this->chatMessages->contains($chatMessage)) {
            $this->chatMessages->add($chatMessage);
            $chatMessage->setUser($this);
        }

        return $this;
    }

    public function removeChatMessage(ChatMessage $chatMessage): self
    {
        if ($this->chatMessages->removeElement($chatMessage)) {
            // set the owning side to null (unless already changed)
            if ($chatMessage->getUser() === $this) {
                $chatMessage->setUser(null);
            }
        }

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

}
