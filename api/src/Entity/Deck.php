<?php

namespace App\Entity;

use App\Repository\DeckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeckRepository::class)]
class Deck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column]
    private ?bool $Private = null;

    #[ORM\ManyToOne(inversedBy: 'User_deck_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User_id = null;

    #[ORM\ManyToOne(inversedBy: 'Game_deck_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $Game_id = null;

    #[ORM\OneToMany(mappedBy: 'Deck_id', targetEntity: DeckCard::class, orphanRemoval: true)]
    private Collection $Deck_DeckCard_id;

    public function __construct()
    {
        $this->Deck_DeckCard_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function isPrivate(): ?bool
    {
        return $this->Private;
    }

    public function setPrivate(bool $Private): static
    {
        $this->Private = $Private;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->User_id;
    }

    public function setUserId(?User $User_id): static
    {
        $this->User_id = $User_id;

        return $this;
    }

    public function getGameId(): ?Game
    {
        return $this->Game_id;
    }

    public function setGameId(?Game $Game_id): static
    {
        $this->Game_id = $Game_id;

        return $this;
    }

    /**
     * @return Collection<int, DeckCard>
     */
    public function getDeckDeckCardId(): Collection
    {
        return $this->Deck_DeckCard_id;
    }

    public function addDeckDeckCardId(DeckCard $deckDeckCardId): static
    {
        if (!$this->Deck_DeckCard_id->contains($deckDeckCardId)) {
            $this->Deck_DeckCard_id->add($deckDeckCardId);
            $deckDeckCardId->setDeckId($this);
        }

        return $this;
    }

    public function removeDeckDeckCardId(DeckCard $deckDeckCardId): static
    {
        if ($this->Deck_DeckCard_id->removeElement($deckDeckCardId)) {
            // set the owning side to null (unless already changed)
            if ($deckDeckCardId->getDeckId() === $this) {
                $deckDeckCardId->setDeckId(null);
            }
        }

        return $this;
    }
}
