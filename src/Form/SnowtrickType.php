<?php

namespace App\Form;

use App\Entity\Snowtrick;
use App\Entity\TrickGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SnowtrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre '
            ])
            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'content'],
                'label' => 'Description '
            ])
            ->add('trickGroup', EntityType::class, [
                'class' => TrickGroup::class,
                'choice_label' => 'label ',
                'placeholder' => 'Sélectionnez',
                'label' => 'Groupe '
            ])
            ->add('pictures', CollectionType::class, [
                'label' => 'Images',
                'entry_type' => PictureType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'constraints' => [
                    new Count(min: 1, minMessage: 'Vous devez ajouter au moins une image.', groups: ['new', 'edit']),
                    new Valid()
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Snowtrick::class,
            'validation_groups' => []
        ]);
    }
}
