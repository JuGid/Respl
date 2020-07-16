<?php

namespace App\Form;

use App\Entity\Budget;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ComptaCreateFromFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              ->add('budgets', EntityType::class, [
                    'class' => Budget::class,
                    'required'=>true,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.nom', 'ASC');
                    },
                    'choice_label' => 'nom',
                    'placeholder' => 'Choisir un budget',
                    'constraints' => [
                      new NotNull([
                        'message' => 'Merci de choisir un budget'
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
                  ]
              ])
        ;
    }

}
