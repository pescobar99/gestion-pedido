<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Entity\Producto;

class PedidoProductoEmbeddedFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productos', EntityType::class, [
                'class' => Producto::class,
                'choice_label' => function ($producto) {
                    return $producto->getNombre() . ' | ' . $producto->getPrecio() . '€';
                }
            ]);
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
        return 'pedidoproducto_form';
    }
}