<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 13/03/14
 * Time: 16:09
 */

namespace Unamur\CobraBundle\Repository;

use Unamur\CobraBundle\Entity\CobraViewer;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
class CobraRemoteCollectionRepository extends EntityRepository
{
    public function findUnregisteredCollectionsForViewer(CobraViewer $viewer)
    {
        $queryBuilder = $this->createQueryBuilder('rc');
        $queryBuilder->where('rc.language = :language')
            ->setParameter('language', $viewer->getLanguage())
            ->orderBy('rc.id', 'ASC');
        return $queryBuilder->getQuery()
            ->getResult();
    }
} 