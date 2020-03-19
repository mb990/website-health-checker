<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    protected $fillable = ['response_code', 'response_time'];

    public function url() {

        return $this->belongsTo(ProjectUrl::class);
    }
}
