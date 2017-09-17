<?php

namespace AppBundle\Repository;

/**
 * FoodRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FoodRepository extends \Doctrine\ORM\EntityRepository
{
    public function search($q)
    {
        return $this->createQueryBuilder('f')
            ->innerjoin('f.foodGroup', 'g')
            ->where('f.name LIKE :q')
            ->orWhere('g.name LIKE :q')
            ->setParameter('q', '%' . $q . '%')
            ->getQuery()
            ->getResult();
    }
}