<?php
namespace App\Media\Entity;

use App\Media\Entity\Media;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Embed extends Media
{
    #[ORM\Column(type: 'text')]
    private $embed;

    public function getEmbed(): bool
    {
        return $this->embed;
    }

    public function setEmbed(string $embed): self
    {
        $this->embed = $embed;

        return $this;
    }
}
