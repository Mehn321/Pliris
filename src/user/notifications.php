<?php
require_once '../../src/shared/sessionmanager.php';

/**
 * Class UserNotificationsManager
 * Handles user notification operations including creation, retrieval and status updates
 * Extends the Database class for database operations
 */
class UserNotificationsManager extends Database {
    private $sessionManager;
    private $id_number;

    /**
     * Constructor initializes session manager and gets user ID
     */
    public function __construct(SessionManager $sessionManager) {
        parent::__construct();
        $this->sessionManager = $sessionManager;
        $this->id_number = $this->sessionManager->getUserId_number();
    }

    /**
     * Retrieves all unseen notifications for the current user
     * Sorted by creation date in descending order
     */
    public function getNotseenNotifications() {
        return $this->retrieve(
            '*',
            'notifications',
            "id_number = '$this->id_number' AND notification_status_id = 1",
            'created_at DESC'
        );
    }

    /**
     * Retrieves all seen notifications for the current user
     * Sorted by creation date in descending order
     */
    public function getSeenNotifications() {
        return $this->retrieve(
            '*',
            'notifications',
            "id_number = '$this->id_number' AND notification_status_id = 2",
            'created_at DESC'
        );
    }

    /**
     * Marks all unseen notifications as seen for the current user
     * Updates notification_status_id from 1 to 2
     */
    public function markAllAsSeen() {
        $id_number = $this->sessionManager->getUserId_number();
        $this->update(
            'notifications',
            'notification_status_id = 2',
            "id_number = '$id_number' AND notification_status_id = 1"
        );
    }

    /**
     * Counts the number of unseen notifications for the current user
     *Number of unseen notifications
     */
    public function not_seenNotificationCount() {
        $id_number = $this->sessionManager->getUserId_number();
        $result = $this->retrieve(
            'COUNT(notification_id) as count',
            'notifications',
            "id_number = '$id_number' AND notification_status_id = 1"
        );
        return $result->fetch_assoc()['count'];
    }
    
    /**
     * Creates return reminder notifications for overdue items
     * Checks if a similar notification was sent in the last 24 hours
     * Only creates new notifications for items that haven't been reminded recently
     */
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
            
            // Create new notification if no previous notification exists or if last notification was more than 24 hours ago
            if (!$lastNotif || strtotime($lastNotif['created_at']) < strtotime('-24 hours')) {
                $message = "Return reminder: {$reservation['item_name']} is due for return on {$reservation['scheduled_return_datetime']}";
                $columns = 'id_number, message, notification_status_id';
                $values = "'$id_number', '$message', 1";
                $this->insert('notifications', $columns, $values);
            }
        }
    }
}
