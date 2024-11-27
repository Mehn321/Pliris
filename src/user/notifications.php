<?php
require_once '../../src/shared/SessionManager.php';
class UserNotificationsManager extends Database {
    private $sessionManager;
    private $id_number;

    public function __construct(SessionManager $sessionManager) {
        parent::__construct();
        $this->sessionManager = $sessionManager;
        $this->id_number = $this->sessionManager->getUserId_number();
    }

    public function getUnseenNotifications() {
        return $this->retrieve(
            '*',
            'notifications',
            "id_number = '$this->id_number' AND notification_status_id = 1",
            'created_at DESC'
        );
    }

    public function getSeenNotifications() {
        return $this->retrieve(
            '*',
            'notifications',
            "id_number = '$this->id_number' AND notification_status_id = 2",
            'created_at DESC'
        );
    }

    public function markAllAsSeen() {
        $id_number = $this->sessionManager->getUserId_number();
        $this->update(
            'notifications',
            'notification_status_id = 2',
            "id_number = '$id_number' AND notification_status_id = 1"
        );
    }

    public function not_seenNotificationCount() {
        $id_number = $this->sessionManager->getUserId_number();
        $result = $this->retrieve(
            'COUNT(notification_id) as count',
            'notifications',
            "id_number = '$id_number' AND notification_status_id = 1"
        );
        return $result->fetch_assoc()['count'];
    }
    
    public function createReturnReminderNotification() {
        $id_number = $this->sessionManager->getUserId_number();
        // Get reservations that are due soon
        $reservations = $this->retrieve(
            'reservations.reserve_id, items.item_name, reservations.scheduled_return_datetime',
            'reservations
            JOIN items ON reservations.item_id = items.item_id',
            "reservations.id_number = '$id_number' AND reservations.reservation_status_ID = 1 AND reservations.scheduled_return_datetime <= NOW()"
        );
        while ($reservation = $reservations->fetch_assoc()) {
            // Check last notification time for this specific reservation
            $lastNotif = $this->retrieve(
                'created_at',
                'notifications',
                "id_number = '$id_number' AND message LIKE '%{$reservation['item_name']}%' AND message LIKE '%return reminder%'",
                'created_at DESC LIMIT 1'
            )->fetch_assoc();
            if (!$lastNotif || strtotime($lastNotif['created_at']) < strtotime('-24 hours')) {
                $message = "Return reminder: {$reservation['item_name']} is due for return on {$reservation['scheduled_return_datetime']}";
                $columns = 'id_number, message, notification_status_id';
                $values = "'$id_number', '$message', 1";
                $this->insert('notifications', $columns, $values);
            }
        }
    }
    
}
