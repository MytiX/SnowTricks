<?php
namespace App\Media\Entity;

use App\Media\Entity\Media;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Embed extends Media
{
    #[ORM\Column(type: 'text')]
    private $embedContent;

    public function getEmbedContent(): string
    {
        return $this->embedContent;
    }

    public function setEmbedContent(string $embedContent): self
    {
        $this->embedContent = $embedContent;

        return $this;
    }
}
