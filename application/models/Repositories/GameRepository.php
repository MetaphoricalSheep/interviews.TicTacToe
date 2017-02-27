<?php

namespace models\Repositories;

use Doctrine\Common\Collections\Criteria;

/**
 * GameRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class GameRepository extends BaseRepository
{
    /**
     * @param int $limit
     * @return array
     */
    public function GetHistory(int $limit) : array
    {
        $qb = $this->createQueryBuilder('g');
        $qb
            ->where($qb->expr()->isNotNull('g.DateEnded'))
            ->orderBy('g.DateEnded', 'DESC')
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}
