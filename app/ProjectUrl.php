<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectUrl extends Model
{
    protected $fillable = ['url', 'check_frequency_id', 'project_id'];

    public function project() {

        return $this->belongsTo(Project::class);
    }

    public function checks() {

        return $this->hasMany(Check::class);
    }

    public function checkFrequency() {

        return $this->belongsTo(Frequency::class);
    }
}

