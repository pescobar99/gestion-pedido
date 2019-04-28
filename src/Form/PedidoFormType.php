<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Entity\Cliente;
use App\Entity\Producto;

class PedidoFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cliente', EntityType::class, [
                'class' => Cliente::class,
                'choice_label' => 'nombre'
            ])
            ->add(
                'importe',
                NumberType::class,
                [
                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control']
                ]
            )
            ->add('productos', CollectionType::class, [
                'entry_type' => PedidoProductoEmbeddedFormType::class,
                'entry_options' => [
                    'label' => false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' => ['class' => 'form-control btn-primary pull-right'],
                    'label' => 'Guardar'
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Pedido'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pedido_form';
    }
}