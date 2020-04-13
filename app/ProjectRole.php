<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectRole extends Model
{
    protected $fillable = ['user_id', 'project_id', 'project_role_type_id'];

    public function user() {

        return $this->hasOne(User::class);
    }

    public function project() {

        return $this->hasOne(Project::class);
    }

    public function projectRole() {

        return $this->hasOne(ProjectRole::class);
    }
}
