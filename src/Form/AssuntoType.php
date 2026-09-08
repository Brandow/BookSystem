<?php

namespace App\Form;

use App\Entity\Assunto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AssuntoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Descricao', TextType::class, [
                'empty_data' => '',
                'label' => 'Descrição do Assunto / Gênero',
                'attr' => [
                    'maxlength' => 20,
                    'placeholder' => 'Ex: Romance, Fantasia, Terror, etc.',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'A descrição do assunto não pode estar em branco.',
                    ]),
                    new Length([
                        'max' => 20,
                        'maxMessage' => 'A descrição do assunto não pode ter mais de {{ limit }} caracteres.',
                    ]),
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assunto::class,
        ]);
    }
}
