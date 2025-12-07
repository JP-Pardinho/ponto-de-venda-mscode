<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Usuario;
use App\Entity\Venda;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DadosVendaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cliente', EntityType::class, [
                'class' => Cliente::class,
                'choice_label' => function (Cliente $cliente) {
                    return $cliente->getNome() . ' (' . $cliente->getCpf() . ')';
                },
                'placeholder' => 'Consumidor sem cadastrado',
                'required' => false,
                'label' => 'Cliente',
                'attr' => [
                    'class' => 'form-select select'
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where('p.ativo = :ativo')
                        ->setParameter('ativo', true)
                        ->orderBy('p.nome', 'ASC');
                },
            ])
            ->add('tipoEntrega', ChoiceType::class, [
                'choices' => [
                    'Retirar na Loja' => Venda::TIPO_RETIRADA,
                    'Entregar no Endereço' => Venda::TIPO_ENTREGA,
                ],
                'expanded' => true,
                'label' => 'Tipo de Venda',
                'attr' => [
                    'class' => 'mb-3'
                ]
            ])
            ->add('enderecoEntrega', TextareaType::class, [
                'required' => false,
                'label' => 'Endereço de Entrega',
                'attr' => [
                    'rows' => 1, 
                    'class' => 'form-control',
                    'placeholder' => 'Rua, Número, Bairro...',
                ],
 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Venda::class,
        ]);
    }
}
