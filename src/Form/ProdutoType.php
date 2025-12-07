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
        $isEdit = $options['is_edit']; 

        $builder
            ->add('nome', null, [
                'label' => 'Nome' . ($isEdit ? ':' : ': <span class="text-danger">*</span>'),
                'label_html' => true,
            ])

            ->add('descricao', null, [
                'label' => 'Descrição' . ($isEdit ? ':' : ': <span class="text-danger">*</span>'),
                'label_html' => true,
            ])
            
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'nome',
                'placeholder' => '- - - Selecione - - -',
                'label' => 'Categoria' . ($isEdit ? ':' : ': <span class="text-danger">*</span>'),
                'label_html' => true,
            ])
            
            ->add('valor', null, [
                'label' => 'Valor' . ($isEdit ? ':' : ': <span class="text-danger">*</span>'),
                'label_html' => true,
            ])

            ->add('quantidadeEstoque', null, [
                'label' => 'Quantidade' . ($isEdit ? ':' : ': <span class="text-danger">*</span>'),
                'label_html' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produto::class,
            'is_edit' => false,
        ]);

        $resolver->setAllowedTypes('is_edit', 'bool');
    }
}
