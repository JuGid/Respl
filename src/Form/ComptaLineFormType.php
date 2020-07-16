<?php

namespace App\Form;

use App\Entity\ComptabiliteLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ComptaLineFormType extends AbstractType
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
            ->add('passif', NumberType::class, [
              'mapped'=>true,
              'required'=>false
            ])
            ->add('actif', NumberType::class, [
              'mapped'=>true,
              'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ComptabiliteLine::class,
        ]);
    }
}
