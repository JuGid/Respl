<?php

namespace App\Form;

use App\Entity\Liste;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ListeCopyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              ->add('listes', EntityType::class, [
                    'class' => Liste::class,
                    'required'=>true,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.nom', 'ASC');
                    },
                    'choice_label' => 'nom',
                    'placeholder' => 'Choisir une liste',
                    'constraints' => [
                      new NotNull([
                        'message' => 'Merci de choisir une liste'
                      ])
                    ]
                  ])
              ->add('nom', TextType::class, [
                  'mapped' => false,
                  'required'=>true,
                  'constraints' => [
                      new NotBlank([
                          'message' => 'Merci d\'entrer un nom',
                      ])
                  ],
              ])
        ;
    }

}
