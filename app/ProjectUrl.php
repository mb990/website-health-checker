<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;

class ProjectUrl extends Model
{
    protected $fillable = ['url'];

    public function project() {

        return $this->belongsTo(Project::class);
    }
}
