<?php

namespace App\DataFixtures;

use App\Comments\Entity\Comments;
use App\Entity\User;
use App\Media\Entity\Embed;
use App\Media\Entity\Picture;
use App\Media\Entity\ProfilePicture;
use App\Tricks\Entity\Tricks;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher, private SluggerInterface $sluggerInterface) {}

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

        $tricksImage = [
            "demo1.jpg",
            "demo2.jpg",
            "demo3.jpg",
            "demo4.jpg",
            "demo5.jpg",
            "demo6.jpg",
            "demo7.jpg",
            "demo8.jpg",
            "demo9.jpg",
            "demo10.jpg",
        ];

        $categorie = [
            'Grabs',
            'Rotations',
            'Flips',
            'Rotations désaxées',
            'Slides',
            'Old school',
        ];

        $user = new User();

        $profilePicture = (new ProfilePicture())->setFilePath('uploads/profile-picture.png');

        $user
            ->setEmail("test@test.fr")
            ->setPassword($this->passwordHasher->hashPassword($user, 'testtest'))
            ->setPseudo('DevryX')
            ->setTokenAuth(sha1('token'.$user->getEmail()))
            ->setActive(1)
            ->setProfilePicture($profilePicture);

            $user2 = new User();
            $user2
                ->setEmail("test2@test.fr")
                ->setPassword($this->passwordHasher->hashPassword($user, 'testtest'))
                ->setPseudo('José')
                ->setTokenAuth(sha1('token'.$user->getEmail()))
                ->setActive(1)
                ->setProfilePicture($profilePicture);
        
        $manager->persist($user);            
        $manager->persist($user2);            
            
        for ($t=0; $t < 10; $t++) {  
            $embed = new Embed();
            $picture = new Picture();

            $embed->setEmbedContent('<iframe width="560" height="315" src="https://www.youtube.com/embed/SQyTWk7OxSI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
                ->setUser($user);
    
            $picture->setFilePath('uploads/'.$tricksImage[$t])
                ->setHeader(true)
                ->setUser($user);

            $tricks = new Tricks(); 
            $tricks
                ->setName($tricksName[$t])
                ->setSlug($this->sluggerInterface->slug($tricks->getName()))
                ->setDescription('Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quisquam consequuntur pariatur impedit, quae animi sit illum fugit aspernatur ullam assumenda autem repudiandae voluptates voluptate reprehenderit, perspiciatis commodi odio! Alias, vitae.
                    Beatae eaque excepturi eveniet officiis iure saepe vitae doloribus provident et quos in similique esse, ullam dolore repudiandae cumque consectetur, corrupti dolores. Totam deleniti, ratione consequatur nesciunt sed suscipit corrupti?
                    Voluptates, sunt consequatur repellendus voluptatibus, neque ducimus reiciendis vero, facere autem adipisci vitae tempore accusamus sit tempora mollitia cupiditate suscipit ea. Minus voluptatum animi atque quaerat delectus quisquam suscipit repudiandae.
                    Nesciunt, id rem? Vero repellat officia illum quod atque, beatae enim explicabo, animi vitae similique iure architecto tempore placeat quia expedita? Mollitia molestiae veritatis corrupti, eveniet nobis quos explicabo necessitatibus.
                    Fuga perspiciatis hic inventore ut nulla earum enim. Quam, vitae a? Aperiam, non ut dolor ipsum similique nulla exercitationem recusandae enim a accusamus tempore hic atque qui repellendus, veritatis excepturi.
                    Dolores qui praesentium eligendi fuga a consequuntur, voluptatem quasi et optio corrupti, at temporibus voluptatum, tempore id labore blanditiis rem cumque officia ducimus deserunt! Consequuntur, sed aliquam? Accusantium, aspernatur quis?
                    Fugiat, asperiores, optio aut nihil consequatur similique delectus natus earum, ipsum sit ratione recusandae enim blanditiis laborum facere perferendis eaque! Impedit deserunt non, harum sint nemo nobis dolor tempore sequi!
                    Laborum neque animi facilis omnis, perspiciatis doloribus? Cum cupiditate veritatis adipisci beatae odit esse dignissimos nesciunt debitis, animi corrupti placeat maxime quam repellendus et numquam unde quas quaerat possimus amet.
                    Placeat accusamus debitis facilis veniam, voluptates, id consequatur illo quisquam excepturi pariatur dolorem eius mollitia iste dicta error perferendis nobis in consectetur. Quia laboriosam sit voluptas debitis tempora? Sapiente, delectus?
                    Natus, nisi sequi maxime ad libero veniam, consectetur ipsa ipsam facilis sunt, excepturi harum a aliquam tempora repellat eligendi iste eaque quidem similique architecto nostrum exercitationem? Perspiciatis repellendus eos eius!
                    Est, quisquam eius non, minus quod exercitationem a provident inventore veniam earum, tempore sint! Dignissimos error distinctio nobis voluptates, minima at inventore quod iure iusto, animi, accusantium itaque ea ullam?
                    Hic nobis quisquam culpa inventore? At, unde cupiditate magni hic earum tempore. Laudantium vel magni mollitia repellat reiciendis minima eos doloribus soluta aut omnis, ex modi totam, iste neque. Recusandae!
                    Rem eveniet inventore, cumque impedit autem consequuntur quasi repudiandae laboriosam, delectus laudantium quos quisquam sunt laborum libero deserunt pariatur perspiciatis! Voluptatum quibusdam sed vitae aut consequatur quasi harum ipsa adipisci.
                    Vero cupiditate, consectetur reprehenderit alias eveniet atque tempore quasi corrupti, officiis, quos ullam incidunt explicabo magni ea a deleniti veritatis perferendis quod quisquam aliquid inventore amet. Cupiditate facilis consequatur reprehenderit.
                    Magnam iusto in illum cum at ad architecto, nam, recusandae, voluptatum optio animi id eos. Ad vitae ipsa magni doloremque, reprehenderit nemo reiciendis repudiandae eos aperiam. Ut laudantium perspiciatis officiis!')
                ->setUser($user)
                ->setGroupStunt($categorie[mt_rand(0, 5)])
                ->addMedia($embed)
                ->addMedia($picture);

            for ($c=0; $c < mt_rand(10, 15); $c++) { 
                $comments = new Comments();
                $comments
                ->setComment("Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quisquam consequuntur pariatur impedit,")
                ->setUser($user)
                ->setTricks($tricks);
    
                $tricks->addComment($comments);
            }
            $manager->persist($tricks);
        }
        
        $manager->flush();
    }
}
