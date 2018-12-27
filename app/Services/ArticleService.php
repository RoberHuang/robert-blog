<?php
/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2018/12/26
 * Time: 16:12
 */

namespace App\Services;


use App\Models\Article;
use App\Models\Admin\Tag;
use Carbon\Carbon;

class ArticleService
{
    protected $tag;

    /**
     * 控制器
     *
     * @param string|null $tag
     */
    public function __construct($tag)
    {
        $this->tag = $tag;
    }

    public function lists()
    {
        if ($this->tag)
            return $this->tagIndexData($this->tag);

        return $this->normalIndexData();
    }

    /**
     * Return data for normal index page
     *
     * @return array
     */
    protected function normalIndexData()
    {
        $articles = Article::with('tags')->with('category')
            ->where('published_at', '<=', Carbon::now())
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')->orderBy('id', 'desc')
            ->simplePaginate(config('blog.posts_per_page'));

        return [
            'title' => config('blog.title'),
            'subtitle' => config('blog.subtitle'),
            'articles' => $articles,
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
        $tag = Tag::where('tag', $tag)->firstOrFail();
        $reverse_direction = (bool) $tag->reverse_direction;
        $order = $reverse_direction ? 'asc' : 'desc';

        $articles = Article::with('category')->where('published_at', '<=', Carbon::now())->where('is_draft', 0)
            ->whereHas('tags', function ($query) use ($tag) {
               $query->where('tag', '=', $tag->tag);
            })
            ->orderBy('published_at', $order)->orderBy('id', $order)
            ->simplePaginate(config('blog.posts_per_page'));

        $articles->appends('tag', $tag->tag);

        $page_image = $tag->page_image ? : config('blog.page_image');

        return [
            'title' => $tag->title,
            'subtitle' => $tag->subtitle,
            'articles' => $articles,
            'page_image' => $page_image,
            'reverse_direction' => $reverse_direction,
            'meta_description' => $tag->meta_description ?: config('blog.description'),
            'tag' => $tag,
        ];
    }
}