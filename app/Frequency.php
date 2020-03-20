<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    protected $fillable = ['name', 'value'];

    public function projectUrl() {

        return $this->hasMany(ProjectUrl::class);
    }
}
