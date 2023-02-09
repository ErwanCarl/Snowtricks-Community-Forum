<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('url', TextType::class, [
            'required' => false,
            'label' => false,
            'attr' => ['class' => 'snowtrick_video'],
            'constraints' => [
                new NotNull(message: 'Veuillez télécharger au moins une vidéo pour la figure.', groups: ['new'])
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
            'validation_groups' => []
        ]);
    }
}
