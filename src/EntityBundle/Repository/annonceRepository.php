<?php

namespace EntityBundle\Repository;

/**
 * annonceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class annonceRepository extends \Doctrine\ORM\EntityRepository
{

    function getLastAnnonces($user){
        $query = $this->getEntityManager()
            ->createQuery('SELECT DISTINCT an
            FROM EntityBundle:annonce an, EntityBundle:ami am
            WHERE an.user = :user  OR  ((an.user = am.user  OR an.user = am.friend) AND (am.user = :user  OR am.friend = :user) AND  am.state = :state)
            ORDER BY an.date DESC')
                ->setParameter('user', $user)
                ->setParameter('state', 'ACTIVE');

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
