<?php
namespace App\Media\Form;

use Exception;
use Traversable;
use App\Media\Entity\Embed;
use App\Media\Entity\Media;
use App\Media\Entity\Picture;
use App\Media\Form\PictureType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
