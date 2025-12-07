<?php

namespace App\Form;

use App\Entity\PagamentoVenda;
use App\Entity\Venda;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagamentoVendaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipoPagamento', ChoiceType::class, [
                'label' => 'Forma de pagamento:' . '<span class="text-danger">*</span>',
                'choices' => [
                    'Dinheiro' => 'DINHEIRO',
                    'Cartão de Crédito' => 'CREDITO',
                    'Cartão de Débito' => 'DEBITO',
                    'Pix' => 'PIX',
                ],
                'attr' => [
                    'class' => 'form-select'
                ],
                'label_html' => true,
            ])

            ->add('parcelas', IntegerType::class, [
                'label' => 'Qtd. Parcelas',
                'data' => 1,
                'attr' => [
                    'class' => 'form-control mb-3',
                    'min' => 1,
                    'max' => 12,
                ],
                'required' => false,
            ])

            ->add('valor', MoneyType::class, [
                'label' => 'Valor a pagar' . '<span class="text-danger">*</span>',
                'currency' => 'BRL',
                'attr' => [
                    'class' => 'form-control text-end'
                ],
                'label_html' => true,
            ])

            ->add('adicionar', SubmitType::class, [
                'label' => 'Adicionar Pagamento',
                'attr' => [
                    'class' => 'btn btn-success w-100'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PagamentoVenda::class,
        ]);
    }
}
