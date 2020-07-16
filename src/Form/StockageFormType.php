<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class StockageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fichier', FileType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer un nom',
                    ])
                ],
            ])
        ;
    }
}
