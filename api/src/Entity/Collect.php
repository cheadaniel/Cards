<?php

namespace App\Entity;

use App\Repository\CollectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollectRepository::class)]
class Collect
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $Quantity = null;

    #[ORM\Column]
    private ?bool $Favourite = null;

    #[ORM\Column]
    private ?bool $Tradable = null;

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

    public function isFavourite(): ?bool
    {
        return $this->Favourite;
    }

    public function setFavourite(bool $Favourite): static
    {
        $this->Favourite = $Favourite;

        return $this;
    }

    public function isTradable(): ?bool
    {
        return $this->Tradable;
    }

    public function setTradable(bool $Tradable): static
    {
        $this->Tradable = $Tradable;

        return $this;
    }
}
