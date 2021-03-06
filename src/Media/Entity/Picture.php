<?php
namespace App\Media\Entity;

use App\Media\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity()]
#[HasLifecycleCallbacks]
class Picture extends Media
{
    #[ORM\Column(type: 'string', length: 255)]
    private $filePath;

    #[ORM\Column(type: 'boolean')]
    private $header = false;

    private ?UploadedFile $file = null;

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function getHeader(): bool
    {
        return $this->header;
    }

    public function setHeader(bool $header): self
    {
        $this->header = $header;

        return $this;
    }

    #[ORM\PostRemove]
    public function preRemove()
    {
        if (file_exists($this->getFilePath())) {
            unlink($this->getFilePath());            
        }
    }

    public function setFile(UploadedFile $uploadedFile)
    {
        $this->file = $uploadedFile;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    #[ORM\PrePersist]
    public function upload()
    {
        if (null != $this->getFile()) {
            $extension = $this->file->guessExtension();
    
            $fileName = md5(uniqid()) . '.' . $extension;
    
            $this->setFilePath($this->upload_directory.'/'.$fileName);
    
            $this->file->move($this->upload_directory, $fileName);
        }
    }

    public function getName()
    {
        return basename($this->getFilePath());
    }
}
