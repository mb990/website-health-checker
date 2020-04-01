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

    public function findByUserAndType($user, $type) {
//        dd($user['id']);
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
