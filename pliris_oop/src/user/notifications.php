<?php
class UserNotificationManager extends Database {
    private $sessionManager;

    public function __construct(SessionManager $sessionManager) {
        parent::__construct();
        $this->sessionManager = $sessionManager;
    }

    public function displayNotifications() {
        echo '<div class="notifications">';
        
        $this->displayOverdueNotifications();
        $this->displaySystemNotifications();
        
        echo '</div>';
    }

    private function displayOverdueNotifications() {
        $overdue = $this->getOverdueReservations();
        while ($row = $overdue->fetch_assoc()) {
            $item = $this->retrieve('item_name', 'items', "item_id='{$row['item_id']}'")->fetch_assoc();
            echo "<li class='reminder'>REMINDER: Please return <strong>{$item['item_name']}</strong> you borrowed</li>";
        }
    }

    private function displaySystemNotifications() {
        $notifications = $this->getSystemNotifications();
        while ($row = $notifications->fetch_assoc()) {
            echo "<li>{$row['message']}</li>";
        }
    }

    private function getOverdueReservations() {
        $userId = $this->sessionManager->getUserId();
        return $this->retrieve(
            '*', 
            'reservations 
            JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID',
            "reservation_status.reservation_stat='reserving' 
            AND reservations.id_number='$userId' 
            AND scheduled_return_datetime <= NOW()"
        );
    }

    private function getSystemNotifications() {
        $userId = $this->sessionManager->getUserId();
        return $this->retrieve(
            '*', 
            'notifications', 
            "id_number='$userId' 
            AND notification_status_id=1"
        );
    }
}