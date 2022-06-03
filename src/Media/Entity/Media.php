<?php

namespace App\Media\Entity;

use DateTime;
use App\Tricks\Entity\Tricks;
use Doctrine\ORM\Mapping as ORM;
use App\Media\Repository\MediaRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'type', type: 'string')]
#[DiscriminatorMap([Picture::class => Picture::class, Embed::class => Embed::class])]
#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[HasLifecycleCallbacks]
abstract class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\ManyToOne(targetEntity: Tricks::class, inversedBy: 'medias')]
    #[ORM\JoinColumn(nullable: false)]
    private $tricks;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->setCreatedAt(new DateTime());
        $this->setUpdatedAt($this->getCreatedAt());
    }

    #[ORM\PreUpdate]
    public function preUpdate()
    {
        $this->setUpdatedAt(new DateTime());
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
}
