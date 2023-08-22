<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\OneToMany(mappedBy: 'User_sender_id', targetEntity: Message::class, orphanRemoval: true)]
    private Collection $User_sender_id;

    #[ORM\OneToMany(mappedBy: 'User_recever_id', targetEntity: Message::class, orphanRemoval: true)]
    private Collection $User_recever_id;

    #[ORM\OneToMany(mappedBy: 'User_id', targetEntity: Deck::class, orphanRemoval: true)]
    private Collection $User_deck_id;

    #[ORM\OneToMany(mappedBy: 'User_id', targetEntity: Commentary::class, orphanRemoval: true)]
    private Collection $User_commentary_id;

    #[ORM\OneToMany(mappedBy: 'User_id', targetEntity: Collect::class, orphanRemoval: true)]
    private Collection $User_collect_id;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function __construct()
    {
        $this->User_sender_id = new ArrayCollection();
        $this->User_recever_id = new ArrayCollection();
        $this->User_deck_id = new ArrayCollection();
        $this->User_commentary_id = new ArrayCollection();
        $this->User_collect_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getUserSenderId(): Collection
    {
        return $this->User_sender_id;
    }

    public function addUserSenderId(Message $userSenderId): static
    {
        if (!$this->User_sender_id->contains($userSenderId)) {
            $this->User_sender_id->add($userSenderId);
            $userSenderId->setUserSenderId($this);
        }

        return $this;
    }

    public function removeUserSenderId(Message $userSenderId): static
    {
        if ($this->User_sender_id->removeElement($userSenderId)) {
            // set the owning side to null (unless already changed)
            if ($userSenderId->getUserSenderId() === $this) {
                $userSenderId->setUserSenderId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getUserReceverId(): Collection
    {
        return $this->User_recever_id;
    }

    public function addUserReceverId(Message $userReceverId): static
    {
        if (!$this->User_recever_id->contains($userReceverId)) {
            $this->User_recever_id->add($userReceverId);
            $userReceverId->setUserReceverId($this);
        }

        return $this;
    }

    public function removeUserReceverId(Message $userReceverId): static
    {
        if ($this->User_recever_id->removeElement($userReceverId)) {
            // set the owning side to null (unless already changed)
            if ($userReceverId->getUserReceverId() === $this) {
                $userReceverId->setUserReceverId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Deck>
     */
    public function getUserDeckId(): Collection
    {
        return $this->User_deck_id;
    }

    public function addUserDeckId(Deck $userDeckId): static
    {
        if (!$this->User_deck_id->contains($userDeckId)) {
            $this->User_deck_id->add($userDeckId);
            $userDeckId->setUserId($this);
        }

        return $this;
    }

    public function removeUserDeckId(Deck $userDeckId): static
    {
        if ($this->User_deck_id->removeElement($userDeckId)) {
            // set the owning side to null (unless already changed)
            if ($userDeckId->getUserId() === $this) {
                $userDeckId->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentary>
     */
    public function getUserCommentaryId(): Collection
    {
        return $this->User_commentary_id;
    }

    public function addUserCommentaryId(Commentary $userCommentaryId): static
    {
        if (!$this->User_commentary_id->contains($userCommentaryId)) {
            $this->User_commentary_id->add($userCommentaryId);
            $userCommentaryId->setUserId($this);
        }

        return $this;
    }

    public function removeUserCommentaryId(Commentary $userCommentaryId): static
    {
        if ($this->User_commentary_id->removeElement($userCommentaryId)) {
            // set the owning side to null (unless already changed)
            if ($userCommentaryId->getUserId() === $this) {
                $userCommentaryId->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Collect>
     */
    public function getUserCollectId(): Collection
    {
        return $this->User_collect_id;
    }

    public function addUserCollectId(Collect $userCollectId): static
    {
        if (!$this->User_collect_id->contains($userCollectId)) {
            $this->User_collect_id->add($userCollectId);
            $userCollectId->setUserId($this);
        }

        return $this;
    }

    public function removeUserCollectId(Collect $userCollectId): static
    {
        if ($this->User_collect_id->removeElement($userCollectId)) {
            // set the owning side to null (unless already changed)
            if ($userCollectId->getUserId() === $this) {
                $userCollectId->setUserId(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
