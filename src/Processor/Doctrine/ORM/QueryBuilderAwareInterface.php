<?php

/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Omines\DataTablesBundle\Processor\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;

interface QueryBuilderAwareInterface
{
    public function setQueryBuilder(QueryBuilder $qb);
}
