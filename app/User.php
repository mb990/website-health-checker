<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Cviebrock\EloquentSluggable\Sluggable;

class User extends Authenticatable
{
    use Notifiable, HasRoles, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['first_name', 'last_name']
            ]
        ];
    }

    public function profile() {

        return $this->hasOne(Profile::class);
    }

    public function createdProjects() {

        return $this->hasMany(Project::class);
    }

    public function memberInProjects() {

        return $this->belongsToMany(Project::class, 'project_users')->withTimestamps();
    }

    public function notificationTypes() {

        return $this->belongsToMany(NotificationType::class, 'notification_type_user')
            ->withPivot('active')
            ->withTimestamps();
    }

    public function notificationSettings() {

        return $this->hasMany(NotificationSetting::class);
    }
}
