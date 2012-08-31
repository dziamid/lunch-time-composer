<?php

namespace LunchTime\BackendBundle\Admin\Menu;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use LunchTime\DeliveryBundle\Entity\Menu\Item;
use LunchTime\DeliveryBundle\Entity\Menu\ItemRepository;
use Sonata\AdminBundle\Builder\DatagridBuilderInterface;

/**
 * Represents admin for container items
 *
 */
class ItemContainerAdmin extends Admin
{
    protected $baseRouteName = 'menu_container';
    protected $baseRoutePattern = '/menu/container';


    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        return $this->getEntityRepository()->addContainerQuery($qb);
    }

    public function getNewInstance()
    {
        $item = new Item();
        $item->setIsBox(true);

        return $item;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('price')
        ;

        if (null === $this->getSubject()->getId()) {
            $formMapper
                ->add('box_type', 'choice', array(
                    'choices' => $this->getEntityRepository()->getAvailableBoxes(),
                ));
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('title')
            ->add('price')
            ->add('box_type')
        ;

    }

    /**
     * @return ItemRepository
     */
    protected function getEntityRepository()
    {
        $class = $this->getClass();

        return $this->getModelManager()->getEntityManager($class)->getRepository($class);
    }

}