<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 26/02/14
 * Time: 15:49
 */

namespace Unamur\CobraBundle\Repository;

use Unamur\CobraBundle\Entity\CobraViewer;
use Unamur\CobraBundle\Entity\CobraCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class CobraCollectionRepository extends EntityRepository
{
    public function findRegisteredCollectionsOfViewer(CobraViewer $viewer)
    {
        $queryBuilder = $this->createQueryBuilder('cc');
        $queryBuilder->where('cc.cobraViewer= :viewer')
                     ->setParameter('viewer', $viewer)
                     ->orderBy('cc.position', 'ASC');
        return $queryBuilder->getQuery()
                            ->getResult();
    }

    public function isAlreadyRegistered(CobraCollection $collection)
    {
        $queryBuilder = $this->createQueryBuilder('cc');
        $queryBuilder->where('cc.cobraViewer = :viewer')
            ->setParameter('viewer', $collection->getCobraViewer())
            ->andWhere('cc.remoteId = :remoteId')
            ->setParameter('remoteId', (int)$collection->getRemoteId());
        return $queryBuilder->getQuery()
            ->getOneOrNullResult();
    }

    public function getMaxPositionOfCollectionInViewer(CobraViewer $viewer)
    {
        $dql = '
            SELECT MAX(cc.position) AS max_pos
            FROM Unamur\CobraBundle\Entity\CobraCollection cc
            WHERE cc.cobraViewer = :viewer
        ';
        $query = $this->_em->createQuery($dql);
        $query->setParameter('viewer', $viewer);

        return $query->getResult();
    }

    public function getPrecedingCollection(CobraCollection $collection)
    {
        $queryBuilder = $this->createQueryBuilder('cc');
        $queryBuilder->where('cc.cobraViewer = :viewer')
            ->setParameter('viewer', $collection->getCobraViewer())
            ->andWhere('cc.position = :position')
            ->setParameter('position', (int)$collection->getPosition()-1);
        return $queryBuilder->getQuery()
            ->getSingleResult();
    }

    public function getFollowingCollection(CobraCollection $collection)
    {
        $queryBuilder = $this->createQueryBuilder('cc');
        $queryBuilder->where('cc.cobraViewer = :viewer')
            ->setParameter('viewer', $collection->getCobraViewer())
            ->andWhere('cc.position = :position')
            ->setParameter('position', (int)$collection->getPosition()+1);
        return $queryBuilder->getQuery()
            ->getSingleResult();
    }

} 