<?php

class NotificationController {
    private $notificationService;

    public function __construct(NotificationService $notificationService) {
        $this->notificationService = $notificationService;
    }

    public function displayNotifications() {
        return $this->notificationService->getAllNotifications();
    }

    public function getUnreadCount() {
        return $this->notificationService->getTotalUnreadNotifications();
    }

    public function markAsRead() {
        if(isset($_POST['notification_id'])) {
            return $this->notificationService->markNotificationAsRead();
        }
    }
}
