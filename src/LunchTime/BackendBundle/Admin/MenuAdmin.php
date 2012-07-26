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
            ->add('due_date');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper;
            //->add('due_date', 'doctrine_orm_datetime_range'); exception
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('due_date');

    }

}