<?php
class AdminNotificationsManager extends Database {

    // returns the nnotifications for the admiin
    public function getAdminNotifications() {
        return $this->retrieve(
            '*',
            'notifications',
            "id_number = '999999999'",
            'notification_id DESC'
        );
    }

    // mark all the notifications of the admin as seen
    public function markAllAsSeen() {
        $this->update(
            'notifications',
            'notification_status_id = 2',  // 2 for seen status
            "id_number = '999999999' AND notification_status_id = 1"  // 1 for unseen status
        );
    }

    // create a new notification for the admin
    public function createNotification($message) {
        $columns = 'id_number, message, created_at, notification_status_id';
        $values = "'999999999', '$message', NOW(), 1";
        $this->insert('notifications', $columns, $values);
    }

    // create a notification for shortage alert
    public function createShortageNotification($threshold) {
        $items = $this->retrieve(
            'item_name, item_quantity',
            'items',
            "active_status_ID = 1 AND item_quantity <= $threshold"
        );
    
        while ($item = $items->fetch_assoc()) {
            $lastNotif = $this->retrieve(
                'created_at',
                'notifications',
                "id_number = '999999999' AND message LIKE '%{$item['item_name']}%' AND message LIKE '%shortage alert%'",
                'created_at DESC LIMIT 1'
            )->fetch_assoc();
    
            if (!$lastNotif || strtotime($lastNotif['created_at']) < strtotime('-48 hours')) {
                $message = "Item shortage alert: {$item['item_name']} has only {$item['item_quantity']} remaining in stock";
                $this->createNotification($message);
            }
        }
    }

    // returns the number of not seen notifications
    public function getNotseenNotificationsCount() {
        $result = $this->retrieve(
            'COUNT(*) as count',
            'notifications',
            "id_number = '999999999' AND notification_status_id = 1"
        );
        return $result->fetch_assoc()['count'];
    }

    // returns the not seen notifications
    public function getNotseenNotifications() {
        return $this->retrieve(
            '*',
            'notifications',
            "id_number = '999999999' AND notification_status_id = 1",
            'created_at DESC'
        );
    }

    // returns the seen notifications
    public function getSeenNotifications() {
        return $this->retrieve(
            '*',
            'notifications',
            "id_number = '999999999' AND notification_status_id = 2",
            'created_at DESC'
        );
    }

    // create a notification for the user if the item returned is approved
    public function createApprovalNotification($id_number, $item_name, $quantity) {
        $message = "Your return for {$quantity} {$item_name}(s) has been approved.";
        $columns = 'id_number, message, notification_status_id';
        $values = "'$id_number', '$message', 1";
        $this->insert('notifications', $columns, $values);
    }

    // create a notification for the user if the item returned is disapproved
    public function createDisapprovalNotification($id_number, $item_name, $quantity) {
        $admin = $this->getAdminInfo();
        $message = "Your return for {$quantity} {$item_name}(s) has been approved. Please return the item/items or you can approach the moderator Sir/Maam: {$admin['first_name']} {$admin['last_name']} or you can contact him/her at {$admin['email']}.";
        
        $this->insert(
            'notifications', 
            'id_number, notification_status_id, message',
            "'$id_number', 1, '$message'"
        );
    }

    // retrieves the admin's first and last name
    private function getAdminInfo() {
        return $this->retrieve('first_name, last_name, email', 'accounts', "id_number='999999999'")->fetch_assoc();
    }
}
