<?php

namespace App\Repositories\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PublishedCriteria.
 *
 * @package namespace App\Repositories\Criteria;
 */
class PublishedCriteria implements CriteriaInterface
{
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
        $model = $model->where([['published_at', '<=', Carbon::now()], 'is_draft' => 0]);
        //->where('published_at', '<=', Carbon::now())
        //            ->where('is_draft', 0)
        return $model;
    }
}
