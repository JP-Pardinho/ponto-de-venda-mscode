<?php

    namespace App\Form;

    use App\Entity\Cliente;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Dom\Text;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\EmailType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class ClienteType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('nome', TextType::class, [
                    'label' => 'Nome Completo',
                    'attr' => [
                        'pattern' => '[A-Za-zÀ-ú ]+',
                        'title' => 'Somente letras e espaços',
                    ]
                ])
                ->add('cpf', TextType::class, [
                    'label' => 'CPF',
                    'attr' => [
                        'maxlength' => 11,
                        'pattern' => '\d*',
                        'inputmode' => 'numeric',
                        'placeholder' => 'Somente números',
                    ],
                ])
                ->add('email', EmailType::class, [
                    'label' => 'E-mail',
                    'required' => false,
                ])
                ->add('telefone', TextType::class, [
                    'label' => 'Telefone',
                    'required' => false,
                    'attr' => [
                        'pattern' => '\d*',
                        'inputmode' => 'numeric',
                        'maxlength' => 11,
                        'placeholder' => 'Ex: 11988887777',
                    ],
                ])
            ;
        }

        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Cliente::class,
            ]);
        }
    }