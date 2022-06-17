<?php

namespace App\Media\Form;

use App\Media\Entity\Picture;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'Image',
                'required' => false,
            ])
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $entity = $form->getData();

        if (null == $entity) {
            $view->vars['file_url'] = null;
            return;
        }

        $view->vars['file_url'] = ($entity->getFilePath() != null) ? $entity->getFilePath() : null;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }
}
