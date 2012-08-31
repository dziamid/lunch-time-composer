<?php

namespace LunchTime\DeliveryBundle\Entity\Client\Order;

use Doctrine\ORM\EntityRepository;

/**
 * ItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ItemRepository extends EntityRepository
{
    public function getListQuery()
    {
        $qb = $this->createQueryBuilder('i')
            ->select('i, mi, o')
            ->innerJoin('i.menu_item', 'mi')
            ->innerJoin('i.order', 'o');

        return $qb->getQuery();
    }

    public function getListByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->select('i')
            ->add('where', $qb->expr()->in('i.id', '?1'))
            ->setParameter('1', $ids);

        return $qb->getArrayResult();
    }



}