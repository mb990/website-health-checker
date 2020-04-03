<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    protected $fillable = ['name'];

    public function settings() {

        return $this->hasMany(NotificationSetting::class);
    }

    public function users() {

        return $this->belongsToMany(User::class, 'notification_type_user')
            ->withPivot('active')
            ->withTimestamps();
    }
}
