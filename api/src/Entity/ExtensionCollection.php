<?php

namespace App\Entity;

use App\Repository\ExtensionCollectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExtensionCollectionRepository::class)]
class ExtensionCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Extension_ExtensionCollection_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Extension $Extension_id = null;

    #[ORM\ManyToOne(inversedBy: 'Collect_ExtensionCollection_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Collect $Collect_id = null;

    public function getId(): ?int
    {
        return $this->id;
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
