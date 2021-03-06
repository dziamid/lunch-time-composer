<?php

namespace LunchTime\BackendBundle\Admin\Menu;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use LunchTime\DeliveryBundle\Entity\Menu\Item;

class ItemAdmin extends Admin
{
    protected $baseRouteName = 'menu_item';
    protected $baseRoutePattern = '/menu/item';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('price')
            ->add('category')
            ->add('box_type', 'choice', array(
                'choices' => Item::getBoxes(),
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('title')
            ->add('price')
            ->add('category');

    }

}