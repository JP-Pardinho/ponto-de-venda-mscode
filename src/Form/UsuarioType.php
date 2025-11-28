<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\CallbackTransformer; 
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = $options['is_edit']; 

        $builder
            ->add('nome', null, [
                'label' => 'Nome' . ($isEdit ? ':' : ': <span class="text-danger">*</span>'),
                'label_html' => true,
            ])

            ->add('email', null, [
                'label' => 'Email' . ($isEdit ? ':' : ': <span class="text-danger">*</span>'), 
                'label_html' => true,
            ])

            ->add('roles', ChoiceType::class, [
                'label' => 'Cargo' . ($isEdit ? ':' : ': <span class="text-danger">*</span>'),
                'label_html' => true,
                'choices' => [
                    'Administrador' => 'ROLE_ADMIN',
                    'Operador' => 'ROLE_USER',
                ],
                'expanded' => true, 
                'multiple' => false, 
            ])
        ;

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    if (!$rolesArray) return null;

                    return $rolesArray[0] ?? null;
                },
                function ($rolesString) {
                    return [$rolesString];
                }
            )
        );

        $passwordConstraints = [
            new Length([
                'min' => 6,
                'minMessage' => 'Sua senha deve ter pelo menos {{ limit }} caracteres',
                'max' => 4096,
            ]),
        ];

        if (!$isEdit) {
            $passwordConstraints = new NotBlank([
                'message' => 'A senha não pode ser vazia',
            ]);
        }
        
        $builder->add('plainPassword', RepeatedType::class, [
            'mapped' => false,
            'type' => PasswordType::class,
            
            'required' => !$isEdit, 
            
            'invalid_message' => 'Os campos de senha devem ser iguais.',
            'first_options'  => [
                'label' => 'Senha' . ($isEdit ? ':' : ': <span class="text-danger">*</span>'),
                'label_html' => true,
                'attr' => [
                    'class' => 'form-control', 
                    'autocomplete' => 'new-password'
                ]
            ],
            'second_options' => [
                'label' => 'Confirme a Senha' . ($isEdit ? ':' : ': <span class="text-danger">*</span>'),
                'label_html' => true,
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'new-password'
                ]
            ],

            'constraints' => $passwordConstraints,
        ]);
    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
            'is_edit' => false,
        ]);

        $resolver->setAllowedTypes('is_edit', 'bool');
    }
}
