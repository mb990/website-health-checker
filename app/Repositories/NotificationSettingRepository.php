<?php


namespace App\Repositories;

use App\NotificationSetting;
use App\Http\Requests\NotificationSettingRequest;
use App\User;

class NotificationSettingRepository
{
    protected $notificationSetting;

    public function __construct(NotificationSetting $notificationSetting)
    {
        $this->notificationSetting = $notificationSetting;
    }

    public function all() {

        return $this->notificationSetting->all();
    }

    public function findById($id) {

        return $this->notificationSetting->find($id);
    }

    public function findByUser($user) {

        return $this->notificationSetting->where('user_id', '=', $user->id)->get();
    }

    public function findByProject($project) {

        return $this->notificationSetting->where('project_id', '=', $project->id)->get();
    }

    public function findByUserAndProject($user, $project) {

        return $this->notificationSetting->where('user_id', '=', $user->id)
            ->where('project_id', '=', $project->id)
            ->get();
    }

    public function findByUserAndType($user, $type) {

        return $this->notificationSetting->where('user_id', '=', $user->id)
            ->where('notification_type_id', '=', $type->id)
            ->get();
    }

    public function findByUserTypeAndProject($user, $type, $project) {

        return $this->notificationSetting->where('user_id', '=', $user->id)
            ->where('notification_type_id', '=', $type->id)
            ->where('project_id', '=', $project->id)
            ->first();
    }

    public function subscribeUserToNotifications($user, $project, $type) {

        $notificationSetting = new NotificationSetting();

        $notificationSetting->user_id = $user->id;
        $notificationSetting->project_id = $project->id;
        $notificationSetting->notification_type_id = $type->id;

        $notificationSetting->save();
    }

    public function subscribeUserToGlobalNotifications(User $user, $type) {

        $user->notificationTypes()->attach($type);
    }

    public function updateSetting($checked, NotificationSetting $setting) {

        $setting->update(['active' => $checked]);
    }
}
