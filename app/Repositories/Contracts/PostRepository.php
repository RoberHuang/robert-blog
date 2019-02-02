<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PostRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface PostRepository extends RepositoryInterface
{
    //
    public function getLists($tag = null);

    public function newerPost(array $post, $tag_name = null);

    public function olderPost(array $post, $tag_name = null);
}
