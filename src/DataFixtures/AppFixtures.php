<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Media\Entity\Embed;
use App\Media\Entity\Picture;
use App\Tricks\Entity\Tricks;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
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

        $embed->setEmbed('Embed 1');

        $picture->setFilePath('/var/www/public/uploads/bc9b7209720dc85167cee77f9bff18a6.jpg');

        $tricks
            ->setName('Je suis un tricks')
            ->setDescription('Je suis une description')
            ->setUser($user)
            ->setGroupStunt('Rotations')
            ->addMedias($embed)
            ->addMedias($picture);

        $manager->persist($user);
        $manager->persist($tricks);
        $manager->flush();
    }
}
