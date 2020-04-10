<?php


namespace App\Services;

use App\Http\Requests\NotificationSettingRequest;
use App\Repositories\NotificationSettingRepository;
use App\Services\NotificationTypeService;

class NotificationSettingService
{
    protected $notificationTypeService;

    public function __construct(NotificationSettingRepository $notificationSetting, NotificationTypeService $notificationTypeService)
    {
        $this->notificationSetting = $notificationSetting;
        $this->notificationTypeService = $notificationTypeService;
    }

    public function all()
    {

        return $this->notificationSetting->all();
    }

    public function findById($id)
    {

        return $this->notificationSetting->findById($id);
    }

    public function findByUser($user)
    {

        return $this->notificationSetting->findByUser($user);
    }

    public function findByProject($project)
    {

        return $this->notificationSetting->findByProject($project);
    }

    public function findByUserAndProject($user, $project)
    {

        return $this->notificationSetting->findByUserAndProject($user, $project);
    }

    public function findByUserTypeAndProject($user, $typeName, $project)
    {
//dd($typeName);
        $type = $this->notificationTypeService->findByName($typeName);
//dd($type);
        return $this->notificationSetting->findByUserTypeAndProject($user, $type, $project);
    }

    public function subscribeUserToNotifications($user, $project)
    {

        $notificationTypes = $this->notificationTypeService->all();

        foreach ($notificationTypes as $type) {

            $this->notificationSetting->subscribeUserToNotifications($user, $project, $type);
            $this->subscribeUserToGlobalNotifications($user, $type);
        }
    }

    public function subscribeUserToGlobalNotifications($user, $type) {

        return $this->notificationSetting->subscribeUserToGlobalNotifications($user, $type);
    }

public function isSettingChecked(NotificationSettingRequest $request, $id) {

    if (!$request->input('active-' . $id) == null) {

        $checked = 1;

    } else {

        $checked = 0;
    }

    return $checked;
}

    public function updateSingleProject(NotificationSettingRequest $request, $settings)
    {
        foreach ($settings as $setting) {

            $checked = $this->isSettingChecked($request, $setting->id);

            $this->notificationSetting->updateSetting($checked, $setting);
        }
    }

//    public function editGlobal($user)
//    {
//        $types = [];
//
//        foreach ($user->notificationTypes as $type) {
//
//            $nType = $this->notificationTypeService->findById($type->id);
//            $types[$nType->id] = $nType;
//        }
//dd($types);
//        return $types;
//    }

    public function updateForType(NotificationSettingRequest $request, $settings) {

        foreach ($settings as $setting) {

            $checked = $this->isSettingChecked($request, $setting->notification_type_id);

            $this->notificationSetting->updateSetting($checked, $setting);
        }
    }

    public function updateGlobal(NotificationSettingRequest $request, $types) {

        foreach ($types as $type) {

            $checked = $this->isSettingChecked($request, $type->id);

            $this->notificationSetting->updateSetting($checked, $type->pivot);
        }
    }
}
