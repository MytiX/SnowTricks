<?php

namespace App\Tricks\Form;

use App\Entity\User;
use App\Media\Form\EmbedType;
use App\Media\Form\MediaType;
use App\Tricks\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\Security;

class TricksType extends AbstractType
{
    public function __construct(private Security $security) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var User $user */
        $user = $this->security->getUser();

        /** @var ?Tricks $tricks */
        $tricks = (array_key_exists('data', $options)) ? $options['data'] : null;

        if ($tricks == null || $user->getId() == $tricks->getUser()->getId()) {
            $builder
                ->add('name', TextType::class, [
                    'required' => true
                ])
                ->add('description', TextareaType::class, [
                    'required' => false
                ])
                ->add('group_stunt', ChoiceType::class, [
                    'placeholder' => 'Catégorie',
                    'choices' => [
                        'Grabs' => 'Grabs',
                        'Rotations' => 'Rotations',
                        'Flips' => 'Flips',
                        'Rotations désaxées' => 'Rotations désaxées',
                        'Slides' => 'Slides',
                        'Old school' => 'Old school',
                    ],
                    'required' => true
                ]);
        }

            $builder
                ->add('medias', CollectionType::class, [
                    'entry_type' => MediaType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                ])
                ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
