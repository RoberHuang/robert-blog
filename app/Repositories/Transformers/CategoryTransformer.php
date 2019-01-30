<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Category;

/**
 * Class CategoryTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class CategoryTransformer extends TransformerAbstract
{
    /**
     * Transform the Category entity.
     *
     * @param \App\Entities\Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
        return [
            'id'         => (int) $model->id,
            'pid'        => (int) $model->pid,
            'name'       => $model->name,
            'title'      => $model->title,
            'level'    => (int) $model->level,
            'description'=> $model->description,
            'order'      => (int) $model->order,
        ];
    }
}
