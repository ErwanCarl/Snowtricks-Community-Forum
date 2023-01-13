<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $nickname = null;

    #[ORM\Column(length: 255)]
    #[Assert\Unique]
    #[Assert\Email(message: 'Le format de l\'email n\'est pas valide.',)]
    private ?string $mail = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?int $validateAccount = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Unique]
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

    public function isValidateAccount(): ?int
    {
        return $this->validateAccount;
    }

    public function setValidateAccount(int $validateAccount): self
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

}
