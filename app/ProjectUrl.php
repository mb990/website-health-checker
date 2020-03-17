<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;

class ProjectUrl extends Model
{
    public function project() {

        return $this->belongsTo(Project::class);
    }
}
