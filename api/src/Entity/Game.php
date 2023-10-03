<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\OneToMany(mappedBy: 'Game_id', targetEntity: Deck::class, orphanRemoval: true)]
    private Collection $Game_deck_id;

    #[ORM\OneToMany(mappedBy: 'Game_id', targetEntity: Extension::class, orphanRemoval: true)]
    private Collection $Game_extension_id;

    #[ORM\OneToMany(mappedBy: 'Game_id', targetEntity: Collect::class, orphanRemoval: true)]
    private Collection $Game_collect_id;

    #[ORM\OneToMany(mappedBy: 'Game_id', targetEntity: Card::class, orphanRemoval: true)]
    private Collection $Game_card_id;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $Image = null;

    public function __construct()
    {
        $this->Game_deck_id = new ArrayCollection();
        $this->Game_extension_id = new ArrayCollection();
        $this->Game_collect_id = new ArrayCollection();
        $this->Game_card_id = new ArrayCollection();
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

    /**
     * @return Collection<int, Deck>
     */
    public function getGameDeckId(): Collection
    {
        return $this->Game_deck_id;
    }

    public function addGameDeckId(Deck $gameDeckId): static
    {
        if (!$this->Game_deck_id->contains($gameDeckId)) {
            $this->Game_deck_id->add($gameDeckId);
            $gameDeckId->setGameId($this);
        }

        return $this;
    }

    public function removeGameDeckId(Deck $gameDeckId): static
    {
        if ($this->Game_deck_id->removeElement($gameDeckId)) {
            // set the owning side to null (unless already changed)
            if ($gameDeckId->getGameId() === $this) {
                $gameDeckId->setGameId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Extension>
     */
    public function getGameExtensionId(): Collection
    {
        return $this->Game_extension_id;
    }

    public function addGameExtensionId(Extension $gameExtensionId): static
    {
        if (!$this->Game_extension_id->contains($gameExtensionId)) {
            $this->Game_extension_id->add($gameExtensionId);
            $gameExtensionId->setGameId($this);
        }

        return $this;
    }

    public function removeGameExtensionId(Extension $gameExtensionId): static
    {
        if ($this->Game_extension_id->removeElement($gameExtensionId)) {
            // set the owning side to null (unless already changed)
            if ($gameExtensionId->getGameId() === $this) {
                $gameExtensionId->setGameId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Collect>
     */
    public function getGameCollectId(): Collection
    {
        return $this->Game_collect_id;
    }

    public function addGameCollectId(Collect $gameCollectId): static
    {
        if (!$this->Game_collect_id->contains($gameCollectId)) {
            $this->Game_collect_id->add($gameCollectId);
            $gameCollectId->setGameId($this);
        }

        return $this;
    }

    public function removeGameCollectId(Collect $gameCollectId): static
    {
        if ($this->Game_collect_id->removeElement($gameCollectId)) {
            // set the owning side to null (unless already changed)
            if ($gameCollectId->getGameId() === $this) {
                $gameCollectId->setGameId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getGameCardId(): Collection
    {
        return $this->Game_card_id;
    }

    public function addGameCardId(Card $gameCardId): static
    {
        if (!$this->Game_card_id->contains($gameCardId)) {
            $this->Game_card_id->add($gameCardId);
            $gameCardId->setGameId($this);
        }

        return $this;
    }

    public function removeGameCardId(Card $gameCardId): static
    {
        if ($this->Game_card_id->removeElement($gameCardId)) {
            // set the owning side to null (unless already changed)
            if ($gameCardId->getGameId() === $this) {
                $gameCardId->setGameId(null);
            }
        }

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
}
