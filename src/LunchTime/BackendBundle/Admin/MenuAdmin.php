<?php

namespace LunchTime\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class MenuAdmin extends Admin
{
    protected $baseRouteName = 'menu';
    protected $baseRoutePattern = '/menu';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('due_date')
            ->add('items', null, array(
                'by_reference' => false,
                'expanded'     => false,
                'multiple'     => true,
                'help'         => "Select meals for menu",
                'label'        => "Meals"
            )
        );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('items');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('due_date');

    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('due_date')
                ->assertNotBlank()
            ->end();
    }

}