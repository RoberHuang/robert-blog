<?php

namespace App\Repositories\Transformers;

use App\Entities\Post;
use League\Fractal\TransformerAbstract;

/**
 * Class PostTransformer
 * @package namespace App\Repositories\Transformers
 */
class PostTransformer extends TransformerAbstract
{
    /**
     * Transform the Post entity.
     *
     * @param Post|null $model
     * @return array
     */
    public function transform(Post $model = null)
    {
        if (!$model) return [];

        return $model->transform();
    }
}
