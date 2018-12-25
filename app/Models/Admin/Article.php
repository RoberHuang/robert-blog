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
     * 把published_at从Y-m-d转成Y-m-d H:i:s
     */
    public function setPublishedAtAttribute($date)
    {
        $this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d', $date);
    }

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
    public function setTitleAttribute($value)
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
     * @param array $tags
     */
    public function syncTags(array $tags)
    {
        Tag::addNeededTags($tags);

        if (count($tags)) {
            $this->tags()->sync(
                Tag::whereIn('tag', $tags)->get()->pluck('id')->all()
            );
            return;
        }

        $this->tags()->detach();
    }
}
