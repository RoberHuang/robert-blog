<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Config.
 *
 * @package namespace App\Entities;
 */
class Config extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'name', 'type', 'value', 'order', 'content', 'remark'
    ];

    public function transform()
    {
        return [
            'id'         => (int) $this->id,
            'title'      => $this->title,
            'name'       => $this->name,
            'type'       => $this->type,
            'value'      => $this->value,
            'order'      => (int) $this->order,
            'content'    => $this->content,
            'remark'     => $this->remark,
        ];
    }

}
