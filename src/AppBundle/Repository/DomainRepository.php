<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class DomainRepository
 * @package AppBundle\Repository
 */
class DomainRepository extends EntityRepository
{
    /**
     * @param int $userId
     * @param int $page
     * @param int $nbPerPage
     * @return Paginator
     */
    public function getDomainsByUserIdPaginator(int $userId, int $page = 1, int $nbPerPage = 10): Paginator
    {
        $query = $this->createQueryBuilder('d')
                      ->leftJoin('d.user', 'u')
                      ->addSelect('u')
                      ->orderBy('d.id', 'DESC')
                      ->where('u.id = :userId')
                      ->setParameter('userId', $userId)
                      ->setFirstResult(($page - 1) * $nbPerPage)
                      ->setMaxResults($nbPerPage);
        return new Paginator($query, true);
    }
    
    /**
     * @param int $page
     * @param int $nbPerPage
     * @return Paginator
     */
    public function getAllDomainsPaginator(int $page = 1, int $nbPerPage = 10): Paginator
    {
        $query = $this->createQueryBuilder('d')
                      ->orderBy('d.id', 'DESC')
                      ->setFirstResult(($page - 1) * $nbPerPage)
                      ->setMaxResults($nbPerPage);
        return new Paginator($query, true);
    }
    
    /**
     * @param int $userId
     * @return int
     */
    public function countDomainsByUserId(int $userId): int
    {
        $query = $this->createQueryBuilder('d')
                      ->leftJoin('d.user', 'u')
                      ->addSelect('u')
                      ->orderBy('d.id', 'DESC')
                      ->where('u.id = :userId')
                      ->setParameter('userId', $userId);
        return \count($query->getQuery()->getResult());
    }
    
    /**
     * @param int $userId
     * @return int
     */
    public function countDomainsEnabledByUserId(int $userId): int
    {
        $query = $this->createQueryBuilder('d')
                      ->leftJoin('d.user', 'u')
                      ->addSelect('u')
                      ->orderBy('d.id', 'DESC')
                      ->where('u.id = :userId')
                      ->setParameter('userId', $userId)
                      ->andWhere('d.enabled = 1');
        return \count($query->getQuery()->getResult());
    }
}
