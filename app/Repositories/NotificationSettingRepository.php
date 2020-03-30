<?php


namespace App\Repositories;

use App\NotificationSetting;
use App\Http\Requests\NotificationSettingRequest;

class NotificationSettingRepository
{
    protected $notificationSetting;

    public function __construct(NotificationSetting $notificationSetting)
    {
        $this->notificationSetting = $notificationSetting;
    }

    public function findById($id) {

        return $this->notificationSetting->find($id);
    }

    public function findByUser($user) {

        $notifications = NotificationSetting::where('user_id', '=', $user->id);

        return $notifications;
    }

    public function findByUserAndType($user, $type) {

        return $this->notificationSetting->where('user_id', '=', $user->id)
            ->where('notification_type_id', '=', $type->id)
            ->first();
    }

    public function subscribeUserToNotifications($user, $project, $type) {

        $notificationSetting = new NotificationSetting();

        $notificationSetting->user_id = $user->id;
        $notificationSetting->project_id = $project->id;
        $notificationSetting->notification_type = $type->id;

        $notificationSetting->save();
    }

    public function update(NotificationSettingRequest $request, $setting) {

        $setting->update(['active' => $request['active']]);
    }
}
