<?php

namespace App\Entity;

use App\Repository\CardCollectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardCollectionRepository::class)]
class CardCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Card_CardCollection_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Card $Card_id = null;

    #[ORM\ManyToOne(inversedBy: 'Collect_CardCollection_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Collect $Collect_id = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCollectId(): ?Collect
    {
        return $this->Collect_id;
    }

    public function setCollectId(?Collect $Collect_id): static
    {
        $this->Collect_id = $Collect_id;

        return $this;
    }
}
