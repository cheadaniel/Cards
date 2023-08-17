<?php

namespace App\Entity;

use App\Repository\CollectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollectRepository::class)]
class Collect
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'User_collect_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User_id = null;

    #[ORM\ManyToOne(inversedBy: 'Game_collect_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $Game_id = null;

    #[ORM\OneToMany(mappedBy: 'Collect_id', targetEntity: CardCollection::class, orphanRemoval: true)]
    private Collection $Collect_CardCollection_id;

    #[ORM\OneToMany(mappedBy: 'Collect_id', targetEntity: ExtensionCollection::class, orphanRemoval: true)]
    private Collection $Collect_ExtensionCollection_id;

    public function __construct()
    {
        $this->Collect_CardCollection_id = new ArrayCollection();
        $this->Collect_ExtensionCollection_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, CardCollection>
     */
    public function getCollectCardCollectionId(): Collection
    {
        return $this->Collect_CardCollection_id;
    }

    public function addCollectCardCollectionId(CardCollection $collectCardCollectionId): static
    {
        if (!$this->Collect_CardCollection_id->contains($collectCardCollectionId)) {
            $this->Collect_CardCollection_id->add($collectCardCollectionId);
            $collectCardCollectionId->setCollectId($this);
        }

        return $this;
    }

    public function removeCollectCardCollectionId(CardCollection $collectCardCollectionId): static
    {
        if ($this->Collect_CardCollection_id->removeElement($collectCardCollectionId)) {
            // set the owning side to null (unless already changed)
            if ($collectCardCollectionId->getCollectId() === $this) {
                $collectCardCollectionId->setCollectId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExtensionCollection>
     */
    public function getCollectExtensionCollectionId(): Collection
    {
        return $this->Collect_ExtensionCollection_id;
    }

    public function addCollectExtensionCollectionId(ExtensionCollection $collectExtensionCollectionId): static
    {
        if (!$this->Collect_ExtensionCollection_id->contains($collectExtensionCollectionId)) {
            $this->Collect_ExtensionCollection_id->add($collectExtensionCollectionId);
            $collectExtensionCollectionId->setCollectId($this);
        }

        return $this;
    }

    public function removeCollectExtensionCollectionId(ExtensionCollection $collectExtensionCollectionId): static
    {
        if ($this->Collect_ExtensionCollection_id->removeElement($collectExtensionCollectionId)) {
            // set the owning side to null (unless already changed)
            if ($collectExtensionCollectionId->getCollectId() === $this) {
                $collectExtensionCollectionId->setCollectId(null);
            }
        }

        return $this;
    }
}
