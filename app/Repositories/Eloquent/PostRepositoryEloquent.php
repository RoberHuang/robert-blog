<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\TagRepository;
use App\Repositories\Criteria\PublishedCriteria;
use App\Repositories\Criteria\WhereCriteria;
use App\Repositories\Presenters\PostPresenter;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\PostRepository;
use App\Entities\Post;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class PostRepositoryEloquent extends BaseRepository implements PostRepository
{
    protected $tag_repository;

    public function __construct(Application $app, TagRepository $tag_repository)
    {
        parent::__construct($app);

        $this->tag_repository = $tag_repository;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //$this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return PostPresenter::class;
    }

    public function getLists($tag = null)
    {
        if ($tag) return $this->tagIndexData($tag);

        return $this->normalIndexData();
    }

    public function newerPost(array $post, $tag_name = null)
    {
        $this->pushCriteria(new WhereCriteria([['published_at', '>', $post['published_at']]]));
        $this->pushCriteria(new PublishedCriteria());
        $query = $this->orderBy('published_at', 'asc');

        if ($tag_name) {
            $query = $query->whereHas('tags', function ($q) use ($tag_name) {
                $q->where('name', '=', $tag_name);
            });
        }
        $new = $query->first();
        $this->resetCriteria();
        return $new;
    }

    public function olderPost(array $post, $tag_name = null)
    {
        $this->pushCriteria(new WhereCriteria([['published_at', '<', $post['published_at']]]));
        $this->pushCriteria(new PublishedCriteria());
        $query = $this->orderBy('published_at', 'desc');

        if ($tag_name) {
            $query = $query->whereHas('tags', function ($q) use ($tag_name) {
                $q->where('name', '=', $tag_name);
            });
        }
        $old =  $query->first();
        $this->resetCriteria();
        return $old;
    }

    /**
     * Return data for normal index page
     *
     * @return array
     */
    protected function normalIndexData()
    {
        $posts = $this->with('user')->with('tags')->with('category')
            ->orderBy('published_at', 'desc')
            ->paginate(config('blog.posts_per_page'));

        return [
            'title' => config('blog.title'),
            'subtitle' => config('blog.subtitle'),
            'posts' => $posts,
            'page_image' => config('blog.page_image'),
            'meta_description' => config('blog.description'),
            'reverse_direction' => false,
            'tag' => null,
        ];
    }

    /**
     * Return data for a tag index page
     *
     * @param string $tag
     * @return array
     */
    protected function tagIndexData($tag)
    {
        $this->tag_repository->pushCriteria(new WhereCriteria(['name' => $tag]));
        $tag = $this->tag_repository->setPresenter("Prettus\\Repository\\Presenter\\ModelFractalPresenter")->first();
        $tag = $tag['data'];

        $reverse_direction = (bool) $tag['reverse_direction'];
        $order = $reverse_direction ? 'asc' : 'desc';

        $posts = $this->with('user')->with('tags')->with('category')->whereHas('tags', function ($query) use ($tag) {
            $query->where('name', '=', $tag['name']);
        })->orderBy('published_at', $order)->paginate(config('blog.posts_per_page'));

        $page_image = $tag['page_image'] ? :config('blog.page_image');

        return [
            'title' => $tag['title'],
            'subtitle' => config('blog.subtitle'),
            'posts' => $posts,
            'page_image' => $page_image,
            'reverse_direction' => $reverse_direction,
            'meta_description' => $tag['description'] ?: config('blog.description'),
            'tag' => $tag,
        ];
    }
}
