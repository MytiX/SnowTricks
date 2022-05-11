<?php

namespace App\Media\Entity;

use DateTime;
use App\Tricks\Entity\Tricks;
use Doctrine\ORM\Mapping as ORM;
use App\Media\Repository\MediaRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[HasLifecycleCallbacks]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $type;

    #[ORM\Column(type: 'string', length: 255)]
    private $filePath;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\ManyToOne(targetEntity: Tricks::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private $tricks;

    private ?UploadedFile $file = null;

    public function __construct(private ?string $upload_directory = null)
    {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
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

    #[ORM\PostRemove]
    public function preRemove()
    {
        unlink($this->getFilePath());
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

    public function setFile(UploadedFile $uploadedFile)
    {
        $this->file = $uploadedFile;
    }

    #[ORM\PrePersist]
    public function upload()
    {
        $extension = $this->file->guessExtension();

        $this->setType($extension);

        $fileName = md5(uniqid()) . '.' . $extension;

        $this->setFilePath($this->upload_directory.'/'.$fileName);

        $this->file->move($this->upload_directory, $fileName);
    }

    public function getName()
    {
        return basename($this->getFilePath());
    }
}
