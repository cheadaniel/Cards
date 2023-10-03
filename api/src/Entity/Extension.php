<?php

namespace App\Entity;

use App\Repository\ExtensionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ExtensionRepository::class)]
#[UniqueEntity(fields: ['Name'], message: 'Ce nom est déjà utilisé, veuillez en choisir un autre')]
class Extension
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $ReleaseDate = null;

    #[ORM\ManyToOne(inversedBy: 'Game_extension_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $Game_id = null;

    #[ORM\OneToMany(mappedBy: 'Extension_id', targetEntity: Card::class, orphanRemoval: true)]
    private Collection $extension_card_id;

    #[ORM\OneToMany(mappedBy: 'Extension_id', targetEntity: ExtensionCollection::class, orphanRemoval: true)]
    private Collection $Extension_ExtensionCollection_id;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Image = null;

    public function __construct()
    {
        $this->extension_card_id = new ArrayCollection();
        $this->Extension_ExtensionCollection_id = new ArrayCollection();
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

    public function getReleaseDate(): ?\DateTimeImmutable
    {
        return $this->ReleaseDate;
    }

    public function setReleaseDate(\DateTimeImmutable $ReleaseDate): static
    {
        $this->ReleaseDate = $ReleaseDate;

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
     * @return Collection<int, Card>
     */
    public function getExtensionCardId(): Collection
    {
        return $this->extension_card_id;
    }

    public function addExtensionCardId(Card $extensionCardId): static
    {
        if (!$this->extension_card_id->contains($extensionCardId)) {
            $this->extension_card_id->add($extensionCardId);
            $extensionCardId->setExtensionId($this);
        }

        return $this;
    }

    public function removeExtensionCardId(Card $extensionCardId): static
    {
        if ($this->extension_card_id->removeElement($extensionCardId)) {
            // set the owning side to null (unless already changed)
            if ($extensionCardId->getExtensionId() === $this) {
                $extensionCardId->setExtensionId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExtensionCollection>
     */
    public function getExtensionExtensionCollectionId(): Collection
    {
        return $this->Extension_ExtensionCollection_id;
    }

    public function addExtensionExtensionCollectionId(ExtensionCollection $extensionExtensionCollectionId): static
    {
        if (!$this->Extension_ExtensionCollection_id->contains($extensionExtensionCollectionId)) {
            $this->Extension_ExtensionCollection_id->add($extensionExtensionCollectionId);
            $extensionExtensionCollectionId->setExtensionId($this);
        }

        return $this;
    }

    public function removeExtensionExtensionCollectionId(ExtensionCollection $extensionExtensionCollectionId): static
    {
        if ($this->Extension_ExtensionCollection_id->removeElement($extensionExtensionCollectionId)) {
            // set the owning side to null (unless already changed)
            if ($extensionExtensionCollectionId->getExtensionId() === $this) {
                $extensionExtensionCollectionId->setExtensionId(null);
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
