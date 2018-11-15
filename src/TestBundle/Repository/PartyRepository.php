<?php

namespace TestBundle\Repository;

use TestBundle\Entity\Party;

/**
 * @method Party|null find($id, $lockMode = null, $lockVersion = null)
 * @method Party|null findOneBy(array $criteria, array $orderBy = null)
 * @method Party[]    findAll()
 * @method Party[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartyRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllByName(string $name)
    {
        $qb = $this->createQueryBuilder('p');

        return $qb->select('p')
            ->where('p.name LIKE :name')
            ->setParameter('name', '%'.$name.'%')
            ->orderBy('p.fromAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}