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

class MediaType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('medias_choice', MediasChoiceType::class, [
                'label' => false,
            ])
            ->add('embed', EmbedType::class, [
                'label' => false
            ])
            ->add('picture', PictureType::class, [
                'label' => false
            ])
            ->setDataMapper($this)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }

    /**
     * Edit form
     */
    public function mapDataToForms($viewData, \Traversable $forms)
    {
        if (null === $viewData) {
            return;
        }

        if (!$viewData instanceof Media) {
            throw new UnexpectedTypeException($viewData, Media::class);
        }

        $forms = iterator_to_array($forms);

        if ($viewData instanceof Picture && array_key_exists('picture', $forms)) {
            $forms['picture']->setData($viewData);
        }
        
        if ($viewData instanceof Embed && array_key_exists('embed', $forms)) {
            $forms['embed']->setData($viewData);
        }
    }
    
    /**
     * Submit form
     */
    public function mapFormsToData(Traversable $forms, &$viewData)
    {
        dump($viewData, 'mapFormsToData');        
    }
}
