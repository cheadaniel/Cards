<?php

namespace App\Entity;

use App\Repository\DeckCardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeckCardRepository::class)]
class DeckCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $Quantity = null;

    #[ORM\ManyToOne(inversedBy: 'Card_DeckCard_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Card $Card_id = null;

    #[ORM\ManyToOne(inversedBy: 'Deck_DeckCard_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Deck $Deck_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(?int $Quantity): static
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getCardId(): ?Card
    {
        return $this->Card_id;
    }

    public function setCardId(?Card $Card_id): static
    {
        $this->Card_id = $Card_id;

        return $this;
    }

    public function getDeckId(): ?Deck
    {
        return $this->Deck_id;
    }

    public function setDeckId(?Deck $Deck_id): static
    {
        $this->Deck_id = $Deck_id;

        return $this;
    }
}
