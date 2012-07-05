<?php

namespace LunchTime\DeliveryBundle\Form\Client\Order;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('amount')
            ->add('order')
            ->add('menu_item')
        ;
    }

    public function getName()
    {
        return 'order_item';
    }
}
