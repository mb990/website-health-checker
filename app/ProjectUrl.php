<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectUrl extends Model
{
    protected $fillable = ['url'];

    public function project() {

        return $this->belongsTo(Project::class);
    }

    public function checks() {

        return $this->hasMany(Check::class);
    }
}
