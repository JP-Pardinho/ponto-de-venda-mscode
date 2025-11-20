<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Entity\Produto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProdutoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome', null, [
                'label' => 'Nome: <span class="text-danger">*</span>',
                'label_html' => true,
            ])

            ->add('descricao', null, [
                'label' => 'Descrição: '
            ])
            
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'nome',
                'placeholder' => '- - - Selecione - - -',
                'label' => 'Categoria: <span class="text-danger">*</span>',
                'label_html' => true,
            ])
            
            ->add('valor', null, [
                'label' => 'Valor: <span class="text-danger">*</span>',
                'label_html' => true,
            ])

            ->add('quantidadeEstoque', null, [
                'label' => 'Quantidade: <span class="text-danger">*</span>',
                'label_html' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produto::class,
        ]);
    }
}
