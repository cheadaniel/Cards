<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Artist = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Image = null;

    #[ORM\Column(length: 255)]
    private ?string $Number = null;

    #[ORM\Column(length: 255)]
    private ?string $Rarity = null;

    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    #[ORM\ManyToOne(inversedBy: 'Game_card_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $Game_id = null;

    #[ORM\ManyToOne(inversedBy: 'extension_card_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Extension $Extension_id = null;

    #[ORM\OneToMany(mappedBy: 'Card_id', targetEntity: Commentary::class, orphanRemoval: true)]
    private Collection $Card_commentary_id;

    #[ORM\OneToMany(mappedBy: 'Card_id', targetEntity: DeckCard::class, orphanRemoval: true)]
    private Collection $Card_DeckCard_id;

    #[ORM\OneToMany(mappedBy: 'Card_id', targetEntity: CardCollection::class, orphanRemoval: true)]
    private Collection $Card_CardCollection_id;

    public function __construct()
    {
        $this->Card_commentary_id = new ArrayCollection();
        $this->Card_DeckCard_id = new ArrayCollection();
        $this->Card_CardCollection_id = new ArrayCollection();
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

    public function getArtist(): ?string
    {
        return $this->Artist;
    }

    public function setArtist(string $Artist): static
    {
        $this->Artist = $Artist;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): static
    {
        $this->Image = $Image;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->Number;
    }

    public function setNumber(string $Number): static
    {
        $this->Number = $Number;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->Rarity;
    }

    public function setRarity(string $Rarity): static
    {
        $this->Rarity = $Rarity;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

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

    public function getExtensionId(): ?Extension
    {
        return $this->Extension_id;
    }

    public function setExtensionId(?Extension $Extension_id): static
    {
        $this->Extension_id = $Extension_id;

        return $this;
    }

    /**
     * @return Collection<int, Commentary>
     */
    public function getCardCommentaryId(): Collection
    {
        return $this->Card_commentary_id;
    }

    public function addCardCommentaryId(Commentary $cardCommentaryId): static
    {
        if (!$this->Card_commentary_id->contains($cardCommentaryId)) {
            $this->Card_commentary_id->add($cardCommentaryId);
            $cardCommentaryId->setCardId($this);
        }

        return $this;
    }

    public function removeCardCommentaryId(Commentary $cardCommentaryId): static
    {
        if ($this->Card_commentary_id->removeElement($cardCommentaryId)) {
            // set the owning side to null (unless already changed)
            if ($cardCommentaryId->getCardId() === $this) {
                $cardCommentaryId->setCardId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DeckCard>
     */
    public function getCardDeckCardId(): Collection
    {
        return $this->Card_DeckCard_id;
    }

    public function addCardDeckCardId(DeckCard $cardDeckCardId): static
    {
        if (!$this->Card_DeckCard_id->contains($cardDeckCardId)) {
            $this->Card_DeckCard_id->add($cardDeckCardId);
            $cardDeckCardId->setCardId($this);
        }

        return $this;
    }

    public function removeCardDeckCardId(DeckCard $cardDeckCardId): static
    {
        if ($this->Card_DeckCard_id->removeElement($cardDeckCardId)) {
            // set the owning side to null (unless already changed)
            if ($cardDeckCardId->getCardId() === $this) {
                $cardDeckCardId->setCardId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CardCollection>
     */
    public function getCardCardCollectionId(): Collection
    {
        return $this->Card_CardCollection_id;
    }

    public function addCardCardCollectionId(CardCollection $cardCardCollectionId): static
    {
        if (!$this->Card_CardCollection_id->contains($cardCardCollectionId)) {
            $this->Card_CardCollection_id->add($cardCardCollectionId);
            $cardCardCollectionId->setCardId($this);
        }

        return $this;
    }

    public function removeCardCardCollectionId(CardCollection $cardCardCollectionId): static
    {
        if ($this->Card_CardCollection_id->removeElement($cardCardCollectionId)) {
            // set the owning side to null (unless already changed)
            if ($cardCardCollectionId->getCardId() === $this) {
                $cardCardCollectionId->setCardId(null);
            }
        }

        return $this;
    }
}
