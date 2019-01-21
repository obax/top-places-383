<?php

namespace App\Repository;


use App\Entity\FeedEntity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FeedRepository extends EntityRepository
{
    /**
     * @param string $location
     * @return FeedEntity[]
     */
    public function byCity(string $location): array
    {
        $em           = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder();
        
        $query = $queryBuilder
            ->setCacheable(true)
            ->from(FeedEntity::class, 'f')
            ->select(['f.city', 'f.moreLink', 'f.provider', 'f.uri'])
            ->where($queryBuilder->expr()->eq('f.city', $queryBuilder->expr()->literal($location)))
            ->getQuery();
        
        $result = $query
            ->setCacheable(true)
            ->setLifetime(3600)
            ->setResultCacheId("$location-feeds")
            ->setResultCacheLifetime(3600)
            ->getArrayResult();
        
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