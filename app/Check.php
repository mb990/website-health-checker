<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    protected $fillable = ['response_code', 'response_time', 'url_id'];

    public function url() {

        return $this->belongsTo(ProjectUrl::class);
    }
}
