<?php

namespace App\Comments\Entity;

use DateTime;
use App\Entity\User;
use App\Tricks\Entity\Tricks;
use Doctrine\ORM\Mapping as ORM;
use App\Comments\Repository\CommentsRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
#[HasLifecycleCallbacks]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $comment;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    private $updatedAt;

    #[ORM\Column(type: 'boolean')]
    private $status = true;

    #[ORM\ManyToOne(targetEntity: Tricks::class, inversedBy: "comments")]
    #[ORM\JoinColumn(nullable: false)]
    private $tricks;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "comments")]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTricks(): ?Tricks
    {
        return $this->tricks;
    }

    public function setTricks(?Tricks $tricks): self
    {
        $this->tricks = $tricks;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->setCreatedAt(new DateTime());
        $this->setUpdatedAt($this->getCreatedAt());
    }
}
