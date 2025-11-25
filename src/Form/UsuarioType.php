<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome', null, [
                'label' => 'Nome:  <span class="text-danger">*</span>',
                'label_html' => true,
            ])

            ->add('email', null, [
                'label' => 'Email: <span class="text-danger">*</span>', 
                'label_html' => true,
            ])

            ->add('plainPassword', RepeatedType::class, [

                'mapped' => false,
                
                'type' => PasswordType::class,
                'invalid_message' => 'Os campos de senha devem ser iguais.',
                'required' => true,
                
                'first_options'  => [
                    'label' => 'Senha: <span class="text-danger">*</span>', 
                    'label_html' => true,
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                
                'second_options' => [
                    'label' => 'Confirme a Senha: <span class="text-danger">*</span>', 
                    'label_html' => true,
                    'attr' => ['autocomplete' => 'new-password'],
                ],

                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, insira uma senha',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Sua senha deve ter pelo menos {{ limit }} caracteres',
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('roles', ChoiceType::class, [
                'label' => 'Cargo: <span class="text-danger">*</span>',
                'label_html' => true,
                'choices' => [
                    'Administrador' => 'ROLE_ADMIN',
                    'Usuário Comum' => 'ROLE_USER',
                ],
                'multiple' => true, 
                'expanded' => true, 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
