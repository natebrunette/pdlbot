<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Comic;
use Doctrine\ORM\EntityRepository;

class ComicRepository extends EntityRepository
{
    /**
     * @param string $search
     * @return Comic[]
     */
    public function search(string $search): array
    {
        return $this->createQueryBuilder('comic')
            ->where('comic.text like :search')
            ->setParameter('search', '%'.$search.'%')
            ->orderBy('comic.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }
}
