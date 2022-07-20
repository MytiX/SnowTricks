<?php

namespace App\Tricks\Form;

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

class TricksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            ])
            ->add('medias', CollectionType::class, [
                'entry_type' => MediaType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
