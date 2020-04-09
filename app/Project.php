<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\ProjectUrl;

class Project extends Model
{
    use Sluggable;

    protected $fillable = ['name', 'up', 'active'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function creator() {

        return $this->belongsTo(User::class, 'user_id');
    }

    public function members() {

        return $this->belongsToMany(User::class, 'project_users')->withTimestamps();
    }

    public function urls() {

        return $this->hasMany(ProjectUrl::class);
    }

    public function notificationSettings() {

        return $this->hasMany(NotificationSetting::class);
    }
}
