<?php

namespace App\Tricks\Form;

use App\Tricks\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\All;

class TricksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('group_stunt', ChoiceType::class, [
                'choices' => [
                    '' => null,
                    'Grabs' => 'Grabs',
                    'Rotations' => 'Rotations',
                    'Flips' => 'Flips',
                    'Rotations désaxées' => 'Rotations désaxées',
                    'Slides' => 'Slides',
                    'Old school' => 'Old school',
                ],
            ])
            ->add('libraries', FileType::class, [
                'required' => false,
                'multiple' => true,
                'mapped' => false,
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'maxSize' => '300k',
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/png',
                                ],
                            ])
                        ]
                    ])
                ],
            ])
            ->add("submit", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
