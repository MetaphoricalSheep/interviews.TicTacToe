<?php

namespace models\Repositories;

use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Collection;

/**
 * GameRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class GameTypeRepository extends EntityRepository
{
    /**
     * @return Collection
     */
    public function findAll() : Collection
    {
        $gameTypes = parent::findAll();
        return new Collection($gameTypes);
    }
}
