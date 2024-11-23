<?php
class UserNotificationsManager extends Database {
    private $sessionManager;

    public function __construct(SessionManager $sessionManager) {
        parent::__construct();
        $this->sessionManager = $sessionManager;
    }

    public function getUserNotifications() {
        $id_number = $this->sessionManager->getUserId_number();
        return $this->retrieve(
            '*',
            'notifications',
            "id_number = '$id_number'",
            'notification_id DESC'
        );
    }

    public function markAllAsSeen() {
        $id_number = $this->sessionManager->getUserId_number();
        $this->update(
            'notifications',
            'notification_status_id = 1',
            "id_number = '$id_number' AND notification_status_id = 0"
        );
    }

    public function not_seenNotificationCount() {
        $id_number = $this->sessionManager->getUserId_number();
        $result = $this->retrieve(
            'COUNT(*) as count',
            'notifications',
            "id_number = '$id_number' AND notification_status_id = 0"
        );
        return $result->fetch_assoc()['count'];
    }
}
