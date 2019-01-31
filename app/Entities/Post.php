<?php

namespace App\Entities;

use App\Services\Markdowner;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Post.
 *
 * @package namespace App\Entities;
 */
class Post extends Model implements Transformable
{
    use TransformableTrait;

    protected $dates = ['published_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'category_id', 'title', 'subtitle', 'keyword', 'description', 'thumbnail', 'content', 'visited', 'published_at', 'is_draft',
    ];

    /**
     * @param $value
     * @return mixed|string
     */
    public function getContentAttribute($value)
    {
        if (preg_match('/.*edit/', \Request::path()) === 0) { // 编辑页面内容不需要markdown
            $markdown = new Markdowner();
            return $markdown->toHTML($value);
        }
        return $value;
    }

    /**
     * 将文章标题转化为 URL 的一部分，以利于SEO
     * @param $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        if (!$this->exists) $this->setUniqueSlug(uniqid(str_random(8)), 0);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag')->select('tags.id');
    }

    protected function setUniqueSlug($title, $extra)
    {
        $slug = str_slug($title . '-' . $extra);

        if (static::where('slug', $slug)->exists()) {
            $this->setUniqueSlug($title, $extra + 1);
            return ;
        }

        $this->attributes['slug'] = $slug;
    }
}
