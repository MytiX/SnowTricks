<?php

namespace App\DataFixtures;

use App\Comments\Entity\Comments;
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
        $tricksName = [
            "Nose grab 360",
            "Nose grab 180",
            "Seat belt 360",
            "Seat belt 180",
            "1080",
            "720",
            "Slide",
            "One foot",
            "Tail grab",
            "Big air 360",
            "Big air 1080",
        ];
        for ($i=0; $i < 2; $i++) {             
            $user = new User();

            $user
                ->setEmail("test$i@test.fr")
                ->setPassword($this->passwordHasher->hashPassword($user, 'testtest'))
                ->setPseudo('Test')
                ->setTokenAuth(sha1('token'.$user->getEmail()))
                ->setActive(1);
            
            $manager->persist($user);

            
            for ($t=0; $t < mt_rand(2, 5); $t++) {  
                $embed = new Embed();
                $picture = new Picture();

                $embed->setEmbedContent('<iframe width="560" height="315" src="https://www.youtube.com/embed/SQyTWk7OxSI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        
                $picture->setFilePath('uploads/e2756844ffd6832e5ec14958649e47e1.jpg')
                        ->setHeader(true);
                $tricks = new Tricks(); 
                $tricks
                    ->setName($tricksName[$t])
                    ->setDescription('Je suis une description')
                    ->setUser($user)
                    ->setGroupStunt('Rotations')
                    ->addMedia($embed)
                    ->addMedia($picture);

                for ($c=0; $c < mt_rand(1, 3); $c++) { 
                    $comments = new Comments();
                    $comments
                    ->setComment("Je suis un commentaire $c")
                    ->setUser($user)
                    ->setTricks($tricks);
        
                    $tricks->addComment($comments);
                }
                $manager->persist($tricks);
            }
        }
        $manager->flush();
    }
}
