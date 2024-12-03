<?php
class AdminNotificationsManager extends Database {
    private $sessionManager;

    public function __construct(SessionManager $sessionManager) {
        parent::__construct();
        $this->sessionManager = $sessionManager;
    }

    public function getAdminNotifications() {
        return $this->retrieve(
            '*',
            'notifications',
            "id_number = '999999999'",
            'notification_id DESC'
        );
    }

    public function markAllAsSeen() {
        $this->update(
            'notifications',
            'notification_status_id = 2',  // 2 for seen status
            "id_number = '999999999' AND notification_status_id = 1"  // 1 for unseen status
        );
    }

    public function getUnseenCount() {
        $result = $this->retrieve(
            'COUNT(*) as count',
            'notifications',
            "id_number = '999999999' AND notification_status_id = 1"
        );
        return $result->fetch_assoc()['count'];
    }

    public function createNotification($message) {
        $columns = 'id_number, message, created_at, notification_status_id';
        $values = "'999999999', '$message', NOW(), 1";
        $this->insert('notifications', $columns, $values);
    }

    public function createShortageNotification($threshold) {
        $items = $this->retrieve(
            'item_name, item_quantity',
            'items',
            "active_status_ID = 1 AND item_quantity <= $threshold"
        );
    
        while ($item = $items->fetch_assoc()) {
            // Check last notification time for this specific item
            $lastNotif = $this->retrieve(
                'created_at',
                'notifications',
                "id_number = '999999999' AND message LIKE '%{$item['item_name']}%' AND message LIKE '%shortage alert%'",
                'created_at DESC LIMIT 1'
            )->fetch_assoc();
    
            if (!$lastNotif || strtotime($lastNotif['created_at']) < strtotime('-48 hours')) {
                $message = "Item shortage alert: {$item['item_name']} has only {$item['item_quantity']} remaining in stock";
                $columns = 'id_number, message, notification_status_id, created_at';
                $values = "'999999999', '$message', 1, NOW()";
                $this->insert('notifications', $columns, $values);
            }
        }
    }


    public function getNotseenNotificationsCount() {
        $result = $this->retrieve(
            'COUNT(*) as count',
            'notifications',
            "id_number = '999999999' AND notification_status_id = 1"
        );
        return $result->fetch_assoc()['count'];
    }

    public function getNotseenNotifications() {
        return $this->retrieve(
            '*',
            'notifications',
            "id_number = '999999999' AND notification_status_id = 1",
            'created_at DESC'
        );
    }

    public function getSeenNotifications() {
        return $this->retrieve(
            '*',
            'notifications',
            "id_number = '999999999' AND notification_status_id = 2",
            'created_at DESC'
        );
    }

    public function createApprovalNotification($id_number, $item_name, $quantity) {
        $message = "Your reservation for {$quantity} {$item_name}(s) has been approved at " . date('M-d-Y h:i:s:a');
        $columns = 'id_number, message, notification_status_id';
        $values = "'$id_number', '$message', 1";
        $this->insert('notifications', $columns, $values);
    }

    public function createDisapprovalNotification($id_number, $item_name, $quantity) {
        $currentTime = date('M-d-Y h:i:s:a');
        $admin = $this->getAdminInfo();
        $message = "Your reservation_status item $item_name with the quantity of $quantity is disapproved at $currentTime. Please return the item/items or you can approach the moderator Mr/Maam: {$admin['first_name']} {$admin['last_name']}.";
        
        $this->insert(
            'notifications', 
            'id_number, notification_status_id, message',
            "'$id_number', 1, '$message'"
        );
    }

    private function getAdminInfo() {
        return $this->retrieve('first_name, last_name', 'accounts', "id_number='999999999'")->fetch_assoc();
    }
}
