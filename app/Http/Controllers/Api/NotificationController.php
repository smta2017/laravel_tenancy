<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Notification;
use App\Models\CentralNotification;
use Illuminate\Http\JsonResponse;

class NotificationController extends AppBaseController
{
    /**
     * Get the authenticated user with explicit model based on context.
     * This ensures that notifications are fetched using the correct notifiable_type.
     */
    protected function getNotifiableUser()
    {
        $user = auth()->user();
        if (!$user) return null;

        if (!tenant() && !($user instanceof \App\Models\CentralUser)) {
            // If we are on central domain but user is not CentralUser instance, 
            // try to find them as CentralUser to align with database notifiable_type
            return \App\Models\CentralUser::find($user->getAuthIdentifier());
        }

        return $user;
    }

    public function unreadCount(): JsonResponse
    {
        $user = $this->getNotifiableUser();
        if (!$user) return $this->sendError('Unauthorized', 401);

        $count = $user->unreadNotifications()->count();
        return $this->sendResponse(['count' => $count], 'Unread notifications count retrieved successfully');
    }

    /**
     * Get notifications for the authenticated user.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = $this->getNotifiableUser();
        if (!$user) return $this->sendError('Unauthorized', 401);

        $notifications = $user->notifications()
            ->latest()
            ->paginate(15);

        return $this->sendResponse($notifications, 'Notifications retrieved successfully');
    }

    /**
     * Mark a specific notification as read.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function markAsRead(string $id): JsonResponse
    {
        $user = $this->getNotifiableUser();
        if (!$user) return $this->sendError('Unauthorized', 401);

        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        return $this->sendResponse($notification, 'Notification marked as read');
    }

    /**
     * Mark all notifications as read for the authenticated user.
     *
     * @return JsonResponse
     */
    public function markAllAsRead(): JsonResponse
    {
        $user = $this->getNotifiableUser();
        if (!$user) return $this->sendError('Unauthorized', 401);

        $user->unreadNotifications->markAsRead();

        return $this->sendSuccess('All notifications marked as read');
    }

    /**
     * Delete a specific notification.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $user = $this->getNotifiableUser();
        if (!$user) return $this->sendError('Unauthorized', 401);

        $notification = $user->notifications()->findOrFail($id);
        $notification->delete();

        return $this->sendSuccess('Notification deleted successfully');
    }
}
