<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class NotificationController extends AppBaseController
{
    /**
     * Get unread notifications count for the authenticated user.
     *
     * @return JsonResponse
     */
    public function unreadCount(): JsonResponse
    {
        $count = Notification::forUser(auth()->id())->unread()->count();
        return $this->sendResponse(['count' => $count], 'Unread notifications count retrieved successfully');
    }

    /**
     * Get notifications for the authenticated user.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $notifications = Notification::forUser(auth()->id())
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
    public function markAsRead(int $id): JsonResponse
    {
        $notification = Notification::forUser(auth()->id())->findOrFail($id);
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
        Notification::forUser(auth()->id())
            ->unread()
            ->update(['read_at' => now()]);

        return $this->sendSuccess('All notifications marked as read');
    }

    /**
     * Delete a specific notification.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $notification = Notification::forUser(auth()->id())->findOrFail($id);
        $notification->delete();

        return $this->sendSuccess('Notification deleted successfully');
    }
}
