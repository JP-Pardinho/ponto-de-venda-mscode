<?php

namespace App\Form;

use App\Entity\Produto;
use App\Entity\VendaItem;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VendaItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('produto', EntityType::class, [
                'class' => Produto::class,
                'choice_label' => 'nome',
                'placeholder' => 'Selecione ou digite...',
                'label' => 'Produto: <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'class' => 'form-select',
                    'autofocus' => true
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where('p.ativo = :ativo')
                        ->setParameter('ativo', true)
                        ->orderBy('p.nome', 'ASC');
                },
            ])

            ->add('quantidade', IntegerType::class, [
                'label' => 'Quantidade: <span class="text-danger">*</span>',
                'data' => 1, 
                'attr' => [
                    'min' => 1,
                    'class' => 'form-control'
                ],
                'label_html' => true,
            ])

            ->add('adicionar', SubmitType::class, [
                'label' => '<i class="bi bi-plus-lg"></i> Adicionar',
                'label_html' => true,
            ])        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VendaItem::class,
        ]);
    }
}
