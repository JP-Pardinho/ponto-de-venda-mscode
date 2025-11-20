<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class AdicionarEstoqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        $estoqueAtual = $options['estoque_atual'];
        $minimoPermitido = $estoqueAtual + 1;

        $builder
            ->add('quantidadeAdicional', IntegerType::class, [
                'label' => 'Quantidade a Adicionar (+)',
                'mapped' => false,
                'attr' => [
                    'min' => 1,
                    'placeholder' => "Estoque atual é $estoqueAtual."
                ],
                'constraints' => [
                    new Positive(['message' => 'A quantidade deve ser maior que zero.'])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'estoque_atual' => 0,
        ]);

        $resolver->setAllowedTypes('estoque_atual', 'int');
    }
}
