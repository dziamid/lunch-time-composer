<?php

namespace LunchTime\BackendBundle\Admin\Client;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class OrderAdmin extends Admin
{
    protected $baseRouteName = 'client_order';
    protected $baseRoutePattern = '/client/order';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('due_date')
            ->add('items', null, array(
                'by_reference' => false,
                'expanded'     => true,
                'multiple'     => true,
                'help'         => "Select meals for menu",
                'label'        => "Meals"
            )
        );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('due_date')
            ->add('client');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('due_date')
            ->add('client')
            ->add('items');
    }


}