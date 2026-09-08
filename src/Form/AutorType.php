<?php

namespace App\Form;

use App\Entity\Autor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AutorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nome', TextType::class, [
                'empty_data' => '',
                'label' => 'Nome do Autor',
                'attr' => ['maxlength' => 40, 'class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'O nome do autor não pode estar em branco.',
                    ]),
                    new Length([
                        'max' => 40,
                        'maxMessage' => 'O nome do autor não pode ter mais de {{ limit }} caracteres.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Autor::class,
        ]);
    }
}
