<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\ProjectUrl;

class Project extends Model
{
    use Sluggable;

    protected $fillable = ['name'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function creator() {

        return $this->belongsTo(User::class);
    }

    public function urls() {

        return $this->hasMany(ProjectUrl::class);
    }
}
