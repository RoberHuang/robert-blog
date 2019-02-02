<?php

namespace App\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LimitCriteria.
 *
 * @package namespace App\Repositories\Criteria;
 */
class LimitCriteria implements CriteriaInterface
{
    protected $start;

    protected $limit;

    public function __construct($start, $limit)
    {
        $this->start = $start;
        $this->limit = $limit;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->skip($this->start)->take($this->limit);

        return $model;
    }
}
