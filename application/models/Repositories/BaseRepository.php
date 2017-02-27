<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/26/2017
 * Time: 10:30 AM
 */

namespace models\Repositories;

use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Collection;


class BaseRepository extends EntityRepository
{
    /**
     * @return Collection<T>
     */
    public function findAll() : Collection
    {
        return new Collection(parent::findAll());
    }
}