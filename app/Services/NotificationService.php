<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\CentralNotification;

class NotificationService
{
    /**
     * Send a notification to a single user.
     *
     * @param int $userId
     * @param string $title
     * @param string $message
     * @param string $type info, success, warning, error
     * @param array|null $data
     * @return Notification
     */
    public static function send(int $userId, string $title, string $message, string $type = 'info', ?array $data = null): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'data'    => $data,
        ]);
    }

    /**
     * Send a notification to multiple users.
     *
     * @param array $userIds
     * @param string $title
     * @param string $message
     * @param string $type info, success, warning, error
     * @param array|null $data
     * @return void
     */
    public static function sendToMany(array $userIds, string $title, string $message, string $type = 'info', ?array $data = null): void
    {
        $payload = [];
        $now = now();
        foreach ($userIds as $userId) {
            $payload[] = [
                'user_id'    => $userId,
                'title'      => $title,
                'message'    => $message,
                'type'       => $type,
                'data'       => $data ? json_encode($data) : null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        Notification::insert($payload);
    }

    /**
     * Send a central notification to multiple users.
     */
    public static function sendCentralToMany(array $userIds, string $title, string $message, string $type = 'info', ?array $data = null): void
    {
        $payload = [];
        $now = now();
        foreach ($userIds as $userId) {
            $payload[] = [
                'user_id'    => $userId,
                'title'      => $title,
                'message'    => $message,
                'type'       => $type,
                'data'       => $data ? json_encode($data) : null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        CentralNotification::insert($payload);
    }

    /**
     * Send a notification to all Admin users.
     */
    public static function notifyAdmins(string $title, string $message, string $type = 'info', ?array $data = null): void
    {
        $adminIds = \App\Models\User::role('Admin')->pluck('id')->toArray();
        if (!empty($adminIds)) {
            self::sendToMany($adminIds, $title, $message, $type, $data);
        }
    }

    /**
     * Send a notification to all Central Admin users.
     */
    public static function notifyCentralAdmins(string $title, string $message, string $type = 'info', ?array $data = null): void
    {
        // Central users are in the 'mysql' (central) connection
        $adminIds = \App\Models\CentralUser::all()->pluck('id')->toArray();
        if (!empty($adminIds)) {
            self::sendCentralToMany($adminIds, $title, $message, $type, $data);
        }
    }

    /**
     * Notify central admins when a new tenant is created.
     */
    public static function tenantCreatedNotify($tenant): void
    {
        self::notifyCentralAdmins(
            'New Tenant Registered',
            'A new tenant has been created: ' . $tenant->id . ' (' . ($tenant->name ?? 'N/A') . ')',
            'info',
            ['tenant_id' => $tenant->id]
        );
    }

    /**
     * Notify admins when a case is created.
     */
    public static function caseAddNotify($theCase): void
    {
        self::notifyAdmins(
            'New Case Created',
            'A new case (ID: ' . $theCase->id . ') was added by ' . auth()->user()->name,
            'success',
            ['case_id' => $theCase->id]
        );
    }

    /**
     * Notify admins when a case is updated.
     */
    public static function caseUpdateNotify($theCase): void
    {
        self::notifyAdmins(
            'Case Updated',
            'Case (ID: ' . $theCase->id . ') was updated by ' . auth()->user()->name,
            'success',
            ['case_id' => $theCase->id]
        );
    }
}
