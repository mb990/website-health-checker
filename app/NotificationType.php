<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    protected $fillable = ['name'];

    public function settings() {

        return $this->hasMany(NotificationSetting::class);
    }

    public function notifications() {

        return $this->hasMany(Notification::class);
    }
}
