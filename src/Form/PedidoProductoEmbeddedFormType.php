<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Producto;

class PedidoProductoEmbeddedFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => 'App\Entity\Producto',
            'choice_label' => function ($producto) {
                return $producto->getNombre() . ' | ' . $producto->getPrecio() . '€';
            }
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return EntityType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pedidoproducto_form';
    }
}