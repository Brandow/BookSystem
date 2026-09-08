<?php

namespace App\Form;

use App\Entity\Assunto;
use App\Entity\Autor;
use App\Entity\Livro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;


class LivroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titulo', TextType::class, [
                'empty_data' => '',
                'label' => 'Título do Livro',
                'attr' => ['maxlength' => 40, 'placeholder' => 'Digite o título do livro'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'O título do livro não pode estar em branco.',
                    ]),
                    new Length([
                        'max' => 40,
                        'maxMessage' => 'O título do livro não pode ter mais de {{ limit }} caracteres.',
                    ]),
                ],
            ])
            ->add('Editora', TextType::class, [
                'empty_data' => '',
                'label' => 'Editora',
                'attr' => ['maxlength' => 40, 'placeholder' => 'Digite o nome da editora'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'O nome da editora não pode estar em branco.',
                    ]),
                    new Length([
                        'max' => 40,
                        'maxMessage' => 'O nome da editora não pode ter mais de {{ limit }} caracteres.',
                    ]),
                ],
            ])
            ->add('Edicao', IntegerType::class, [
                'empty_data' => '',
                'label' => 'Edição',
                'attr' => ['maxlength' => 10, 'placeholder' => 'Digite a edição do livro'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'A edição do livro não pode estar em branco.',
                    ]),
                    new Length([
                        'max' => 10,
                        'maxMessage' => 'A edição do livro não pode ter mais de {{ limit }} caracteres.',
                    ]),
                ],
            ])
            ->add('AnoPublicacao', IntegerType::class, [
                'empty_data' => '',
                'label' => 'Ano de Publicação',
                'attr' => ['maxlength' => 4, 'placeholder' => 'Digite o ano de publicação', 'oninput' => 'if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'O ano de publicação não pode estar em branco.',
                    ]),
                    new Range([
                        'min' => 1900,
                        'max' => (int) date('Y'),
                        'notInRangeMessage' => 'O ano de publicação deve estar entre {{ min }} e {{ max }}.',
                    ]),
                ],
            ])
            ->add('Valor', MoneyType::class, [
                'empty_data' => '',
                'currency' => 'BRL',
                'divisor' => 1,
                'scale' => 2,
                'label' => 'Valor do Livro',
                'attr' => ['maxlength' => 10, 'placeholder' => 'R$ 0,00'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'O valor do livro não pode estar em branco.',
                    ])
                ],
            ])
            ->add('autores', EntityType::class, [
                'empty_data' => [],
                'class' => Autor::class,
                'choice_label' => 'Nome',
                'multiple' => true,
                'by_reference' => false,
                'constraints' => [
                    new Count([
                        'min' => 1,
                        'minMessage' => 'Selecione pelo menos um autor.',
                    ]),
                ],
            ])
            ->add('assuntos', EntityType::class, [
                'empty_data' => [],
                'label' => 'Assunto / Gênero',
                'class' => Assunto::class,
                'choice_label' => 'Descricao',
                'multiple' => true,
                'by_reference' => false,
                'constraints' => [
                    new Count([
                        'min' => 1,
                        'minMessage' => 'Selecione pelo menos um assunto/gênero.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livro::class,
        ]);
    }
}
