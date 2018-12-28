<?php

namespace App\Models\Admin;

use App\Services\Markdowner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $dates = ['published_at'];

    protected $fillable = [
        'article_title', 'subtitle', 'cate_id', 'article_keywords', 'article_description', 'article_thumb', 'article_content',
        'is_draft', 'layout', 'article_author', 'article_frequency', 'published_at',
    ];

    /**
     * 返回 published_at 字段的日期部分
     */
    public function getPublishDateAttribute($value)
    {
        return $this->published_at->format('Y-m-d');
    }

    /**
     * 返回 published_at 字段的时间部分
     */
    public function getPublishTimeAttribute($value)
    {
        return $this->published_at->format('g:i A');
    }

    /**
     * article_content 字段别名
     * $article->content 就会执行该方法
     */
    public function getContentAttribute($value)
    {
        return $this->article_content;
    }

    /**
     * 把published_at从Y-m-d转成Y-m-d H:i:s
     */
    /*public function setPublishedAtAttribute($date)
    {
        $this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d', $date);
    }*/

    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }

    /**
     * The many-to-many relationship between articles and tags.
     *
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag_pivot');
    }

    /**
     * Set the title attribute and automatically the slug
     *
     * @param string $value
     */
    public function setArticleTitleAttribute($value)
    {
        $this->attributes['article_title'] = $value;

        if (!$this->exists) {
            $this->setUniqueSlug(uniqid(str_random(8)), 0);
        }
    }

    /**
     * Recursive routine to set a unique slug
     *
     * @param string $title
     * @param mixed $extra
     */
    public function setUniqueSlug($title, $extra)
    {
        $slug = str_slug($title . '-' . $extra);

        if (static::where('slug', $slug)->exists()) {
            $this->setUniqueSlug($title, $extra + 1);
            return ;
        }

        $this->attributes['slug'] = $slug;
    }

    /**
     * Set the HTML content automatically when the raw content is set
     *
     * @param string $value
     */
    public function setArticleContentAttribute($value)
    {
        $markdown = new Markdowner();

        $this->attributes['article_content'] = $value;
        $this->attributes['content_html'] = $markdown->toHTML($value);
    }

    /**
     * Sync tag relation adding new tags as needed
     *
     * @param array $tag_ids
     */
    public function syncTags(array $tag_ids)
    {
        //Tag::addNeededTags($tags);

        if (count($tag_ids)) {
            $this->tags()->sync(
                $tag_ids
            );
            return;
        }

        $this->tags()->detach();
    }
}
