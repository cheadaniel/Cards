<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $CreatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'User_sender_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User_sender_id = null;

    #[ORM\ManyToOne(inversedBy: 'User_recever_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User_recever_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): static
    {
        $this->Content = $Content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUserSenderId(): ?User
    {
        return $this->User_sender_id;
    }

    public function setUserSenderId(?User $User_sender_id): static
    {
        $this->User_sender_id = $User_sender_id;

        return $this;
    }

    public function getUserReceverId(): ?User
    {
        return $this->User_recever_id;
    }

    public function setUserReceverId(?User $User_recever_id): static
    {
        $this->User_recever_id = $User_recever_id;

        return $this;
    }
}
