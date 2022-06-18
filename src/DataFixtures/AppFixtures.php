<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Media\Entity\Embed;
use App\Media\Entity\Picture;
use App\Tricks\Entity\Tricks;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        $tricks = new Tricks();
        $user = new User();
        $embed = new Embed();
        $picture = new Picture();

        $user
            ->setEmail('test@test.fr')
            ->setPassword($this->passwordHasher->hashPassword($user, 'testtest'))
            ->setPseudo('Test')
            ->setTokenAuth(sha1('token'.$user->getEmail()))
            ->setActive(1);

        $embed->setEmbedContent('<iframe width="560" height="315" src="https://www.youtube.com/embed/oUJolR5bX6g" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');

        $picture->setFilePath('uploads/e2756844ffd6832e5ec14958649e47e1.jpg')
                ->setHeader(true);

        $tricks
            ->setName('Je suis un tricks')
            ->setDescription('Je suis une description')
            ->setUser($user)
            ->setGroupStunt('Rotations')
            ->addMedia($embed)
            ->addMedia($picture);

        $manager->persist($user);
        $manager->persist($tricks);
        $manager->flush();
    }
}
