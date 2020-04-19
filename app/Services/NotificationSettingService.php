<?php


namespace App\Services;

use App\Http\Requests\NotificationSettingRequest;
use App\Http\Requests\SingleProjectNotificationSettingRequest;
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

    public function findByUserAndType($user, $type) {

        return $this->notificationSetting->findByUserAndType($user, $type);
    }

    public function findByUserTypeAndProject($user, $typeName, $project)
    {

        $type = $this->notificationTypeService->findByName($typeName);

        return $this->notificationSetting->findByUserTypeAndProject($user, $type, $project);
    }

    public function delete($setting) {

        return $this->notificationSetting->delete($setting);
    }

    public function subscribeUserToNotifications($user, $project)
    {

        $notificationTypes = $this->notificationTypeService->all();

        foreach ($notificationTypes as $type) {

            $this->notificationSetting->subscribeUserToNotifications($user, $project, $type);
        }

        if (!$this->isUserSubscribed($user)) {

            $this->subscribeUserToGlobalNotifications($user);
        }
    }

    public function unsubscribeUserFromNotifications($user, $project) {

        $settings = $this->findByUserAndProject($user, $project);

        foreach ($settings as $setting) {

            $this->delete($setting);
        }
    }

    public function subscribeUserToGlobalNotifications($user) {

        $types = $this->notificationTypeService->all();

        foreach ($types as $type) {

            $this->notificationSetting->subscribeUserToGlobalNotifications($user, $type);
        }
    }

    public function isUserSubscribed($user) {

        $types = $this->notificationTypeService->all();

        $pivotTypes = $this->notificationTypeService->findByUser($user);

        $diff = $types->diff($pivotTypes);

        if ($diff->isEmpty()) {

            return true;
        }

        return false;
    }

public function isSettingChecked(SingleProjectNotificationSettingRequest $request, $id) {

    if (!$request->input('active-' . $id) == null) {

        $checked = 1;

    } else {

        $checked = 0;
    }

    return $checked;
}

    public function isGlobalSettingChecked(NotificationSettingRequest $request, $id) {

        if (!$request->input('active-' . $id) == null) {

            $checked = 1;

        } else {

            $checked = 0;
        }

        return $checked;
    }

    public function updateSingleProject(SingleProjectNotificationSettingRequest $request, $settings)
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

            $checked = $this->isGlobalSettingChecked($request, $setting->notification_type_id);

            $this->notificationSetting->updateSetting($checked, $setting);
        }
    }

    public function updateGlobal(NotificationSettingRequest $request, $types) {

        foreach ($types as $type) {

            $checked = $this->isGlobalSettingChecked($request, $type->id);

            $this->notificationSetting->updateSetting($checked, $type->pivot);
        }
    }
}
