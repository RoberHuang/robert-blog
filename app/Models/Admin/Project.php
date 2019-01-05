<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->belongsToMany(Admin::class, 'project_user', 'project_id', 'user_id');
    }

    public function syncProjectUser(array $tag_ids)
    {
        if (count($tag_ids)) {
            $this->users()->sync(
                $tag_ids
            );
            return;
        }

        $this->users()->detach();
    }
}
