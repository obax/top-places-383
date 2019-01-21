<?php

namespace App\Repository;


use App\Entity\FeedEntity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FeedRepository extends EntityRepository
{
    public function byCity($location): array
    {
        $em           = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder();
        $query = $queryBuilder
            ->from(FeedEntity::class, 'f')
            ->select(['f.name', 'f.moreLink'])
            ->where($queryBuilder->expr()->eq('f.city', $queryBuilder->expr()->literal($location))
            );
    
        $result= $query->getQuery()->setMaxResults(1)->setHydrationMode(Query::HYDRATE_OBJECT)->execute();
    
        if(!count($result))
        {
            throw new NotFoundHttpException("Unable to find feed for $location");
        }
        return $result;
    }
    
    public function byProvider($provider)
    {
    
    }

}