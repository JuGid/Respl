<?php

namespace App\Form;

use App\Entity\ListeLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ListeInterneFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'mapped' => true,
                'required'=>true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer un nom',
                    ])
                ],
            ])
            ->add('prix', NumberType::class, [
              'mapped'=> true,
              'required'=>true
            ])
            ->add('optionnel', CheckboxType::class, [
              'mapped'=>true,
              'required'=>false,
              'label'=>'Pas obligatoire'
            ])
            ->add('lien', TextType::class, [
              'mapped'=>true,
              'required'=>true,
              'constraints' => [
                  new NotBlank([
                      'message' => 'Merci d\'entrer un nom',
                  ])
              ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ListeLine::class,
        ]);
    }
}
