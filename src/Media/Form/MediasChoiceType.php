<?php
namespace App\Media\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MediasChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('medias_choice', ChoiceType::class, [
                'choices' => [
                    'Picture' => 'picture',
                    'Embed' => 'embed',
                ],
                'placeholder' => '',
                'label' => 'Selectionner votre média',
                'mapped' => false
            ])
        ;

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
