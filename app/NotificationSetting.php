<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = ['active'];

    public function user() {

        return $this->belongsTo(User::class, 'user_id');
    }

    public function project() {

        return $this->belongsTo(Project::class, 'project_id');
    }

    public function type() {

        return $this->belongsTo(NotificationType::class, 'notification_type_id');
    }
}
